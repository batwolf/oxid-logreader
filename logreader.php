<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$logs = array_filter(array_reverse(explode(PHP_EOL, file_get_contents('log/oxideshop.log'))));

$limit = 10;
$count = 0;

?><!doctype HTML>
<html>
<head>
    <style>
        html, body {
            width: 98%;
            padding: 1%;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
<?php foreach($logs as $log): ?>
    <?php if($count > $limit) continue; ?>
    <?php $explodedLog = explode('OXID Logger.', $log); ?>
    <b><?=str_replace('] OXID', '', $explodedLog[0]) ?></b><br /><br />
    <?php

    $log = explode('\\n', $log);
    foreach($log as $line) {
        if(empty($line)) {
            continue;
        }

        if(strstr($line, ', called in')) {
            $ex = explode(', called in', $line);
            $line = $ex[0];
            $line .= '<br /><br />';
            $line .= 'Called in ' . $ex[1];
        }

        $line = str_replace('[stacktrace]', '<br /><b>STACKTRACE</b><br />', $line);

        if(strstr($line, '): ')) {
            $exp = explode('): ', $line);
            $line = $exp[0] . '): ' . '<br />';
            $line .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . $exp[1] . '</b><br />';
        }

        echo $line . '<br />';

    }
    $count++;
    echo '<br /><hr /><br />';
    ?>
<?php endforeach; ?>
</body>
</html>
