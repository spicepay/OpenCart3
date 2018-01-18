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
     

        $data['action']="https://www.spicepay.com/p.php";





		

        $data['merchant_url'] = $data['action'] . '?siteId=' . $data['spicepay_login'] .

				'&amountUSD='			. $order_info['total'] .

				'&orderId='			. $data['inv_id']	.

				'&language=en';

//tesrt

		$this->id = 'payment';

return $this->load->view('extension/payment/spicepay', $data);



	}



    public function callback() {



        if (isset($_POST['paymentId']) && isset($_POST['orderId']) && isset($_POST['hash']) 
        && isset($_POST['paymentCryptoAmount']) && isset($_POST['paymentAmountUSD']) 
        && isset($_POST['receivedCryptoAmount']) && isset($_POST['receivedAmountUSD'])) {
    
    
    
            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($_POST['orderId']);
    
            $paymentId = addslashes(filter_input(INPUT_POST, 'paymentId', FILTER_SANITIZE_STRING));
            $orderId = addslashes(filter_input(INPUT_POST, 'orderId', FILTER_SANITIZE_STRING));
            $hash = addslashes(filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));    
            $clientId = addslashes(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING));
            $paymentAmountBTC = addslashes(filter_input(INPUT_POST, 'paymentAmountBTC', FILTER_SANITIZE_NUMBER_INT));
            $paymentAmountUSD = addslashes(filter_input(INPUT_POST, 'paymentAmountUSD', FILTER_SANITIZE_STRING));
            $receivedAmountBTC = addslashes(filter_input(INPUT_POST, 'receivedAmountBTC', FILTER_SANITIZE_NUMBER_INT));
            $receivedAmountUSD = addslashes(filter_input(INPUT_POST, 'receivedAmountUSD', FILTER_SANITIZE_STRING));
            $status = addslashes(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING));
            
            if(isset($_POST['paymentCryptoAmount']) && isset($_POST['receivedCryptoAmount'])) {
                $paymentCryptoAmount = addslashes(filter_input(INPUT_POST, 'paymentCryptoAmount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
                $receivedCryptoAmount = addslashes(filter_input(INPUT_POST, 'receivedCryptoAmount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            }
            else {
                $paymentCryptoAmount = addslashes(filter_input(INPUT_POST, 'paymentAmountBTC', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
                $receivedCryptoAmount = addslashes(filter_input(INPUT_POST, 'receivedAmountBTC', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            }
    
            $secretCode = $this->config->get('payment_spicepay_key');
    
            $hashString = $secretCode . $paymentId . $orderId . $clientId . $paymentCryptoAmount . $paymentAmountUSD . $receivedCryptoAmount . $receivedAmountUSD . $status;
             
             die(md5($hashString).' - '. $hash.' - '.$secretCode);   
    
            if (0 == strcmp(md5($hashString), $hash)) {
    
               $sum = $order_info['total']; 
        
              if ((float)$sum != $receivedAmountUSD) {
        
                        echo  'не совпадает сумма заказа';
        
              } else {
        
        
                  $this->model_checkout_order->addOrderHistory($orderId, 5, 'spicepay');
        
                  echo 'OK';
        
              
        
              }
    
                
    
            }else {
    
                echo 'fail';
        
            }
    
            
    
            
    
            
    
        } else {
    
            echo 'fail';
    
         
    
        }



	}

}

?>