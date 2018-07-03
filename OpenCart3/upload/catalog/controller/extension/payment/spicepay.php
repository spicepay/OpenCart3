<?php

class ControllerExtensionPaymentSpicepay extends Controller {


	public function index() {

        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['button_back'] = $this->language->get('button_back');

        $data['text_loading'] = $this->language->get('text_loading');



        $this->load->model('checkout/order');


        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

  
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));

        $data['spicepay_login'] = $this->config->get('payment_spicepay_login');

        $data['spicepay_key']= $this->config->get('payment_spicepay_key');

        $data['success_url']= $this->config->get('payment_spicepay_success_url');

        // Номер заказа

        $data['inv_id'] = $this->session->data['order_id'];
     

        $data['action']="https://www.spicepay.com/pay.php";





		

        $data['merchant_url'] = $data['action'] . '?siteId=' . $data['spicepay_login'] .

				'&amountUSD='			. $order_info['total'] .

				'&orderId='			. $data['inv_id']	.

				'&language=en';

//tesrt

		$this->id = 'payment';

return $this->load->view('extension/payment/spicepay', $data);



	}



    public function callback() {



if (isset($_POST['paymentId']) || isset($_GET['paymentId'])) {



	if (isset($_POST['paymentId']) && isset($_POST['orderId']) && isset($_POST['hash']) 

&& isset($_POST['paymentAmountBTC']) && isset($_POST['paymentAmountUSD']) 

&& isset($_POST['receivedAmountBTC']) && isset($_POST['receivedAmountUSD'])) {

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($_POST['orderId']);

        $paymentId = $_POST['paymentId'];

    $orderId = $_POST['orderId'];

    $hash = $_POST['hash'];    

    $clientId = $_POST['clientId'];

    $paymentAmountBTC = $_POST['paymentAmountBTC'];

    $paymentAmountUSD = $_POST['paymentAmountUSD'];

    $receivedAmountBTC = $_POST['receivedAmountBTC'];

    $receivedAmountUSD = $_POST['receivedAmountUSD'];

    $status = $_POST['status'];

    $secretCode = $this->config->get('spicepay_key');


} elseif (isset($_GET['paymentId']) && isset($_GET['orderId']) && isset($_GET['hash']) 

&& isset($_GET['paymentAmountBTC']) && isset($_GET['paymentAmountUSD']) 

&& isset($_GET['receivedAmountBTC']) && isset($_GET['receivedAmountUSD'])) {

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($_GET['orderId']);

        $paymentId = $_GET['paymentId'];

    $orderId = $_GET['orderId'];

    $hash = $_GET['hash'];    

    $clientId = $_GET['clientId'];

    $paymentAmountBTC = $_GET['paymentAmountBTC'];

    $paymentAmountUSD = $_GET['paymentAmountUSD'];

    $receivedAmountBTC = $_GET['receivedAmountBTC'];

    $receivedAmountUSD = $_GET['receivedAmountUSD'];

    $status = $_GET['status'];

    $secretCode = $this->config->get('spicepay_key');

}
        

        if (strcmp($_SERVER['REMOTE_ADDR'], '217.23.11.119') == 0 || strcmp($_SERVER['REMOTE_ADDR'], '51.254.46.119') == 0) {

            

        if (0 == strcmp(md5($secretCode . $paymentId . $orderId . $clientId . $paymentAmountBTC . $paymentAmountUSD . $receivedAmountBTC . $receivedAmountUSD . $status), $hash)) {

            

        

       $sum = $order_info['total']; 

      if ((float)$sum != $receivedAmountUSD) {

                echo  'не совпадает сумма заказа';

      } else {


          $this->model_checkout_order->addOrderHistory($orderId, 5, 'spicepay');

          echo 'OK';

      

      }

            

        }

        }

        

        

    } else {

        echo 'fail';

     

    }



	}

}

?>