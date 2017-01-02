<?php
namespace Irkit;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Garden\Cli\Cli;

class Config {
    private static $files = [
        'config'    => 'config.json',
        'messages'  => 'messages.json',
    ];
    private static $path = 'src/templates';

    public static function create($ipAddress) {
        $loader = new Twig_Loader_Filesystem(static::$path);
        $twig = new Twig_Environment($loader);
        echo "createing...\n";
        foreach (static::$files as $file) {
            sleep(1);
            file_put_contents($file, $twig->render($file, [
                'ipAddress' => $ipAddress
            ]));
            echo "\033[1;34mcreate:\033[0m {$file}\n";
        }
        sleep(1);
        echo "... finish.\n";
        echo Cli::greenText("Please setup config.json and messages.json.\n");
        exit(1);
    }
}
