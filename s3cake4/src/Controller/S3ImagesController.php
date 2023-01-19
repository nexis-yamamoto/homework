<?php
declare(strict_types=1);

namespace App\Controller;

use Aws\S3\S3Client;
use Aws\Credentials\CredentialProvider;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

use Cake\Core\Configure; // app_localを参照したい


/**
 * S3Images Controller
 *
 * @property \App\Model\Table\S3ImagesTable $S3Images
 * @method \App\Model\Entity\S3Image[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class S3ImagesController extends AppController
{
    /**
     * Delete method
     *
     * @param string|null $key object key
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($key = null)
    {
        try {
            $bucketName = Configure::read('AWS_BUCKET_NAME');
            $s3 = new S3Client([
                'region'  => Configure::read('AWS_REGION_CODE'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => Configure::read('AWS_ACCESS_KEY_ID'),
                    'secret' => Configure::read('AWS_SECRET_ACCESS_KEY'),
                ]
            ]);

            $result = $s3->deleteObject(array(
                'Bucket' => $bucketName,
                'Key'    => $key
            ));
            $this->log_r($result);

            if ($result['@metadata']['statusCode'] === 204) {
                $this->Flash->success(__('The s3 image has been deleted.'));
            } else {
                $this->Flash->error(__('The s3 image could not be deleted. Please, try again.'));
            }
        } catch (S3Exception $e) {
            $this->Flash->error(__('The exception occurred while s3 image operating.') . $e->getMessage());
            $this->log($e->getMessage());
        }
        return $this->redirect(['action' => 'index']);
    }


    /* ファイルをシンプルにアップロードするサンプル
    */
    public function simple_upload()
    {
        if ($this->request->is('post')) {
            $myFile = $this->request->getData('my_file');
            $name = $myFile->getClientFilename();
            $path = WWW_ROOT . 'upload' . DS . $name;
            $myFile->moveTo($path);
        }
    }

    public function index() {
        $objectList = array();
        //https://bucket-name.s3.region-code.amazonaws.com/key-name
        $meta = array(
            'bucket' => Configure::read('AWS_BUCKET_NAME'),
            'region' => Configure::read('AWS_REGION_CODE'),
            'uriBase' => 'https://' . Configure::read('AWS_BUCKET_NAME') . '.s3.' . Configure::read('AWS_REGION_CODE') . '.amazonaws.com/'
        );
        
        try {
            // AWS SDK for PHPのクライアントを作成
            $s3 = new S3Client([
                'region'  => Configure::read('AWS_REGION_CODE'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => Configure::read('AWS_ACCESS_KEY_ID'),
                    'secret' => Configure::read('AWS_SECRET_ACCESS_KEY'),
                ]
            ]);

            $objectList = $s3->listObjects([
                'Bucket' => Configure::read('AWS_BUCKET_NAME'),
                //'MaxKeys' => 100,
                //'Prefix' => ''
            ]);
            $this->log_r($objectList);
        } catch (S3Exception $e) {
            $this->Flash->error(__('The exception occurred while s3 image operating.') . $e->getMessage());
            $this->log($e->getMessage());
        }
        $this->set(compact('meta', 'objectList'));
    }

    public function upload()
    {
        if ($this->request->is('post')) {
            $myFile = $this->request->getData('my_file');
            $name = $myFile->getClientFilename();
            $this->log($name);

            // 参考: stream interface
            // https://github.com/php-fig/http-message/blob/master/src/StreamInterface.php
            $readStream = $myFile->getStream();
            $this->log_r(get_class_methods($readStream));

            $this->log(Configure::read('AWS_ACCESS_KEY_ID'));
            $this->log(Configure::read('AWS_SECRET_ACCESS_KEY'));

            // AWS SDK for PHPのクライアントを作成
            $s3 = new S3Client([
                'region'  => Configure::read('AWS_REGION_CODE'),
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => Configure::read('AWS_ACCESS_KEY_ID'),
                    'secret' => Configure::read('AWS_SECRET_ACCESS_KEY'),
                ]
            ]);

            # S3ストリームを登録、以後標準ストリーム関数で
            $s3->registerStreamWrapper();
            $bucketName = Configure::read('AWS_BUCKET_NAME');
            if ($writeStream = fopen("s3://$bucketName/$name", 'w')) {
                # アップロードファイルをS3へバッファ読み書き
                while (FALSE === $readStream->eof()) {
                    $data = $readStream->read(1024);
                    fwrite($writeStream, $data, 1024);
                }
                $readStream->close();
                fclose($writeStream);
            }
            return $this->redirect(['action' => 'index']);
        }
    }

}
