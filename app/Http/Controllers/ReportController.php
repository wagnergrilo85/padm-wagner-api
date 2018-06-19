<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;

class ReportController extends Controller
{

    public function generateReport($folder_tmp){

        $file_jrxml = "cities.jrxml";
        $file_pdf   = "cities.pdf";

        $input      = public_path() . '/reports/jasper/' . $file_jrxml;
        $output     = public_path() . '\reports\pdf\tmp\\' . $folder_tmp;

        mkdir($output);

        // instancia um novo objeto JasperPHP
        $report = new PHPJasper;

        // echo $report->process( $input, $output, $this->getDatabaseConfig() )->output();

        $report->process(
            $input,
            $output,
            $this->getDatabaseConfig()
        )->execute();

        $file = $output . "\\" . $file_pdf;
        $path = $file;

//        // caso o arquivo não tenha sido gerado retorno um erro 404
//        if (!file_exists($file)) {
////            abort(404, 'Arquivo: ' . $name . ' nao encontrado');
//            return 'Arquivo: ' . $namePdf . ' nao encontrado';
//        }

        //*** caso tenha sido gerado pego o conteudo
        // $file = file_get_contents($file);

//        return response()->file(public_path() . '\reports\pdf\\' . $file_pdf);
//        return response()->file(public_path() . '\reports\pdf\wagner.pdf');
        return response()->file($output . '\\' . $file_pdf);
    }

    public function clearReport($folder_tmp){
        $dir = public_path() . '\reports\pdf\tmp\\' . $folder_tmp;
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
        if(file_exists($dir))
            return false;
        else
            return;
    }

    public function getPpdf($filename){
        return response()->file(public_path() . '\reports\pdf\tmp\\' . $filename);
    }

    public function getDatabaseConfig()
    {
//        return [
//            'driver' => env('DB_CONNECTION'),
//            'host' => env('DB_HOST'),
//            'port' => env('DB_PORT'),
//            'username' => env('DB_USERNAME'),
//            'password' => env('DB_PASSWORD'),
//            'database' => env('DB_DATABASE'),
//            'jdbc_dir' => base_path() . env('JDBC_DIR', '\vendor\geekcom\phpjasper\bin\jasperstarter\jdbc'),
//        ];

        $jdbc_dir   = base_path()   . '\vendor\geekcom\phpjasper\bin\jasperstarter\jdbc';

        return [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [],
            'db_connection' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'solteti_tests',
                'username' => 'wagner',
                'password' => '34712211',
                'jdbc_driver' => 'com.mysql.jdbc.Driver',
                'jdbc_url' => 'jdbc:mysql://localhost/padm',
                'jdbc_dir' => $jdbc_dir
            ]
        ];
    }

    public function index()
    {

        $input      = public_path() . '/reports/jasper/cities.jrxml';
        $output     = public_path() . '/reports/pdf';
        $jdbc_dir   = base_path()   . '\vendor\geekcom\phpjasper\bin\jasperstarter\jdbc';

        $file_jrxml = "cities.jrxml";
        $file_pdf   = "cities.pdf";

//        $input      = public_path() . '/reports/jasper/cities.jrxml';
//        $output     = public_path() . '\reports\pdf\tmp\\' . $folder_tmp;

//        $options = [
//            'format' => ['pdf'],
//            'locale' => 'en',
//            'params' => [],
//            'db_connection' => [
//                'driver' => 'mysql',
//                'host' => '127.0.0.1',
//                'port' => '3306',
//                'database' => 'solteti_tests',
//                'username' => 'wagner',
//                'password' => '34712211',
//                'jdbc_driver' => 'com.mysql.jdbc.Driver',
//                'jdbc_url' => 'jdbc:mysql://localhost/padm',
//                'jdbc_dir' => $this->getDatabaseConfig()
//            ]
//        ];

        $jasper = new PHPJasper;

        $jasper->process(
            $input,
            $output,
            $this->getDatabaseConfig()
        )->execute();


//        $jasper->process(
//            $input,
//            $output,
//            $options
//        )->execute();

//        echo $jasper->process( $input, $output, $this->getDatabaseConfig() )->output();

    }

}
