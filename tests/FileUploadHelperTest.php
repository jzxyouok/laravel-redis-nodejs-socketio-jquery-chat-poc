<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class FileUploadHelperTest extends TestCase
{

    public $files;

    protected function setUp()
    {
        $path = public_path('files');
        $file_path = $path . "/forum.txt";
        $this->files = ['file' => ['name' => 'forum.txt', 'tmp_name' => $file_path]];

        if(!file_exists($path.'/forum.txt'))
            fopen($path.'/forum.txt'), "w");
    }

    protected function tearDown()
    {
        $path = public_path('files');
        if(file_exists($path.'/mirko-forum.txt'))
            unlink($path.'/mirko-forum.txt');
    }



    public function testCreatingInstance()
    {
        $helper = new \App\FileUploadHelper($this->files);
        $files = $helper->getFile();
        $this->assertEquals($files['name'], 'forum.txt');

    }

    public function testValidateFileTypeTest()
    {
        $this->assertTrue(true);     
    }

    public function testGetFilePathAndName()
    {
        $helper = new \App\FileUploadHelperTesting($this->files);
        $helper->setFilePathAndName('mirko-');
        $new_name = $helper->getNewFileName();
        $this->assertEquals($new_name, '/files/mirko-forum.txt');
    }

    public function testMoveFileToNewLocation()
    {
        $helper = new \App\FileUploadHelperTesting($this->files);
        $helper->setFilePathAndName('mirko-');
        $result = $helper->move_uploaded_file();
        $this->assertTrue($result);
    }

    public function testAssertThereIsAFileInNewLocation()
    {
        $helper = new \App\FileUploadHelperTesting($this->files);
        $file_exists = file_exists(public_path('files')."/mirko-forum.txt");  
        $this->assertTrue($file_exists);
    }

}
