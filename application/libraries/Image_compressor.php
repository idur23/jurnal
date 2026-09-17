<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Image Compressor Library untuk CodeIgniter 3 (PHP 8.x + GD)
 * Kompresi Foto Otomatis ~50% Ukuran File (Bytes) Sebelum Upload ke Google Drive.
 */
class Image_compressor {

    protected $CI;
    protected $enabled;
    protected $target_percent;
    protected $min_quality;
    protected $max_dimension;
    protected $min_filesize;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('google_drive', TRUE, TRUE);
        $cfg = $this->CI->config->item('google_drive') ?: array();

        $this->enabled        = isset($cfg['image_compression_enabled']) ? (bool)$cfg['image_compression_enabled'] : TRUE;
        $this->target_percent = isset($cfg['image_compression_target']) ? (int)$cfg['image_compression_target'] : 50;
        $this->min_quality    = isset($cfg['image_compression_min_quality']) ? (int)$cfg['image_compression_min_quality'] : 60;
        $this->max_dimension  = isset($cfg['image_compression_max_dimension']) ? (int)$cfg['image_compression_max_dimension'] : 4096;
        $this->min_filesize   = isset($cfg['image_compression_min_filesize']) ? (int)$cfg['image_compression_min_filesize'] : 153600; // 150 KB
    }

    /**
     * Memproses Kompresi Gambar Otomatis ~50%
     *
     * @param string $source_path Path absolut file di server
     * @return array Hasil kompresi (success, is_compressed, original_size, compressed_size, compression_ratio, quality, message)
     */
    public function compress($source_path) {
        $original_size = @filesize($source_path);

        $default_result = array(
            'success'           => true,
            'is_compressed'     => false,
            'original_size'     => $original_size ?: 0,
            'compressed_size'   => $original_size ?: 0,
            'compression_ratio' => 0.0,
            'quality'           => 100,
            'processed_path'    => $source_path,
            'message'           => 'Kompresi dilewati (File non-image atau file kecil).'
        );

        if (!$this->enabled || !file_exists($source_path) || !$original_size) {
            return $default_result;
        }

        // Cek ekstensi file
        $ext = strtolower(pathinfo($source_path, PATHINFO_EXTENSION));
        if (in_array($ext, array('heic', 'heif'))) {
            return array(
                'success'        => false,
                'is_compressed'  => false,
                'original_size'  => $original_size,
                'compressed_size'=> $original_size,
                'processed_path' => $source_path,
                'message'        => 'Format foto HEIC belum didukung oleh server. Silakan gunakan JPG/PNG.'
            );
        }

        // Cek MIME Type (Hanya JPEG, PNG, WEBP)
        $image_info = @getimagesize($source_path);
        if (!$image_info || !isset($image_info['mime'])) {
            return $default_result; // File non-image (PDF, DOCX, ZIP, DLL)
        }

        $mime = strtolower($image_info['mime']);
        $allowed_mimes = array('image/jpeg', 'image/jpg', 'image/png', 'image/webp');
        if (!in_array($mime, $allowed_mimes)) {
            return $default_result;
        }

        // Cek ukuran file minimal (Bypass jika file < 150 KB)
        if ($original_size < $this->min_filesize) {
            $default_result['message'] = 'File sudah kecil (< 150 KB), kompresi dilewati untuk menjaga kualitas.';
            return $default_result;
        }

        $target_bytes = (int)ceil($original_size * ($this->target_percent / 100.0));
        $temp_dest = dirname($source_path) . '/temp_comp_' . time() . '_' . basename($source_path);

        try {
            // Load Gambar ke Memory GD
            $img = $this->create_gd_image($source_path, $mime);
            if (!$img) {
                return $default_result;
            }

            // Normalisasi Orientasi EXIF (Smartphone Camera)
            $img = $this->fix_exif_orientation($img, $source_path);

            $width = imagesx($img);
            $height = imagesy($img);

            // Periksa jika PNG memiliki Transparansi Alpha
            $is_png = ($mime === 'image/png');
            $has_transparency = $is_png && $this->is_png_transparent($img);

            // Algoritma Kompresi Kualitas Bertahap (85 -> 80 -> 75 -> 70 -> 65 -> 60)
            $current_quality = 85;
            $best_quality = 85;
            $best_size = $original_size;
            $compressed_ok = false;

            while ($current_quality >= $this->min_quality) {
                $this->save_gd_image($img, $temp_dest, $mime, $current_quality, $has_transparency);
                $current_size = @filesize($temp_dest);

                if ($current_size && $current_size < $best_size) {
                    $best_size = $current_size;
                    $best_quality = $current_quality;
                }

                if ($current_size && $current_size <= $target_bytes) {
                    $compressed_ok = true;
                    break;
                }

                $current_quality -= 5;
            }

            // Jika Kualitas 60 masih > target size, lakukan Resize Proporsional Halus (Aspect Ratio Tetap)
            if (!$compressed_ok && $best_size > $target_bytes) {
                $scale_factor = 0.90; // Resize 90%
                $cur_w = $width;
                $cur_h = $height;

                for ($attempt = 0; $attempt < 4; $attempt++) {
                    $cur_w = (int)round($cur_w * $scale_factor);
                    $cur_h = (int)round($cur_h * $scale_factor);

                    if ($cur_w < 400 || $cur_h < 400) break; // Jangan resize di bawah 400px

                    $resized_img = imagecreatetruecolor($cur_w, $cur_h);
                    if ($has_transparency) {
                        imagealphablending($resized_img, false);
                        imagesavealpha($resized_img, true);
                    }
                    imagecopyresampled($resized_img, $img, 0, 0, 0, 0, $cur_w, $cur_h, $width, $height);

                    $this->save_gd_image($resized_img, $temp_dest, $mime, $this->min_quality, $has_transparency);
                    imagedestroy($resized_img);

                    $current_size = @filesize($temp_dest);
                    if ($current_size && $current_size < $best_size) {
                        $best_size = $current_size;
                    }

                    if ($current_size && $current_size <= $target_bytes) {
                        $compressed_ok = true;
                        break;
                    }
                }
            }

            imagedestroy($img);

            // Validasi Hasil Kompresi
            if (file_exists($temp_dest) && $best_size > 0 && $best_size < $original_size) {
                // Ganti file original dengan file hasil kompresi
                @copy($temp_dest, $source_path);
                @unlink($temp_dest);

                $final_size = filesize($source_path);
                $ratio = round(((($original_size - $final_size) / $original_size) * 100), 1);

                return array(
                    'success'           => true,
                    'is_compressed'     => true,
                    'original_size'     => $original_size,
                    'compressed_size'   => $final_size,
                    'compression_ratio' => $ratio,
                    'quality'           => $best_quality,
                    'processed_path'    => $source_path,
                    'message'           => "Ukuran berkas berhasil dikompres sebesar {$ratio}% (dari " . number_format($original_size/1024, 1) . " KB menjadi " . number_format($final_size/1024, 1) . " KB)."
                );
            } else {
                if (file_exists($temp_dest)) @unlink($temp_dest);
                return $default_result;
            }

        } catch (Exception $e) {
            if (file_exists($temp_dest)) @unlink($temp_dest);
            log_message('error', 'Image Compression Exception: ' . $e->getMessage());
            return $default_result;
        }
    }

    /**
     * Helper Load GD Image dari File
     */
    private function create_gd_image($file, $mime) {
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                return @imagecreatefromjpeg($file);
            case 'image/png':
                return @imagecreatefrompng($file);
            case 'image/webp':
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file) : false;
            default:
                return false;
        }
    }

    /**
     * Helper Simpan GD Image ke Temp File
     */
    private function save_gd_image($img, $dest, $mime, $quality, $has_transparency = false) {
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                @imagejpeg($img, $dest, $quality);
                break;
            case 'image/png':
                if ($has_transparency) {
                    imagealphablending($img, false);
                    imagesavealpha($img, true);
                }
                // Map PNG compression level (0-9) dari quality 100-0
                $png_quality = (int)round((100 - $quality) / 10);
                if ($png_quality > 9) $png_quality = 9;
                @imagepng($img, $dest, $png_quality);
                break;
            case 'image/webp':
                if (function_exists('imagewebp')) {
                    @imagewebp($img, $dest, $quality);
                } else {
                    @imagejpeg($img, $dest, $quality);
                }
                break;
        }
    }

    /**
     * Helper Koreksi Orientasi EXIF dari Kamera HP (Android / iPhone)
     */
    private function fix_exif_orientation($img, $source_path) {
        if (!function_exists('exif_read_data')) return $img;

        $exif = @exif_read_data($source_path);
        if (!$exif || empty($exif['Orientation'])) return $img;

        $orientation = (int)$exif['Orientation'];
        switch ($orientation) {
            case 3:
                return imagerotate($img, 180, 0);
            case 6:
                return imagerotate($img, -90, 0);
            case 8:
                return imagerotate($img, 90, 0);
            default:
                return $img;
        }
    }

    /**
     * Helper Cek apakah PNG memiliki Transparansi Alpha
     */
    private function is_png_transparent($img) {
        $w = imagesx($img);
        $h = imagesy($img);

        // Sample 30 titik piksel acak untuk mendeteksi alpha channel
        for ($i = 0; $i < 30; $i++) {
            $x = rand(0, $w - 1);
            $y = rand(0, $h - 1);
            $rgba = imagecolorat($img, $x, $y);
            $alpha = ($rgba & 0x7F000000) >> 24;
            if ($alpha > 0) return true;
        }
        return false;
    }
}
