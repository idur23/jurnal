<?php
$link = mysqli_connect('localhost', 'root', '', 'jg_enterprise');
$res = mysqli_query($link, 'SELECT * FROM users LIMIT 1');
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
