<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ridvanbaluyos\Face\FaceDetection as FaceDetection;

class Latihan_Face_API extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        // Replace <Subscription Key> with a valid subscription key.
        $ocpApimSubscriptionKey = '580164ff1e56485cbe80a855c6c0eb99';

        // Replace <My Endpoint String> with the string in your endpoint URL.
        $uriBase = 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0';

        $imageUrl =
            'https://upload.wikimedia.org/wikipedia/commons/3/37/Dagestani_man_and_woman.jpg';

        // This sample uses the PHP5 HTTP_Request2 package
        // (https://pear.php.net/package/HTTP_Request2).
        require_once 'HTTP/Request2.php';

        $request = new Http_Request2($uriBase . '/detect');
        $url = $request->getUrl();

        $headers = array(
            // Request headers
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
        );
        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'returnFaceId' => 'true',
            'returnFaceLandmarks' => 'false',
            'returnFaceAttributes' => 'age,gender,headPose,smile,facialHair,glasses,' .
                'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise'
        );
        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body parameters
        $body = json_encode(array('url' => $imageUrl));

        // Request body
        $request->setBody($body);

        try {
            $response = $request->send();
            echo "<pre>" .
                json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT) . "</pre>";
        } catch (HttpException $ex) {
            echo "<pre>" . $ex . "</pre>";
        }
        $this->load->view('latihan_face_API', []);
    }
}
