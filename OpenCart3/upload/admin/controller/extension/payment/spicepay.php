<?php

// Module: SpicePay - OpenCart 3
// Version: 1.0.1


class ControllerExtensionPaymentSpicepay extends Controller {





	private $error = array();



	public function index() {



		$this->load->language('extension/payment/spicepay');

		

		$this->document->setTitle = $this->language->get('heading_title');



		$this->load->model('setting/setting');

// 		echo $this->validate();

// exit();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('payment_spicepay', $this->request->post);



			$this->session->data['success'] = $this->language->get('text_success');

			// if ($this->request->post['save_stay']){

			// 	$this->response->redirect($this->url->link('payment/spicepay', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));

			// }

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));

		}



		$data['heading_title'] = $this->language->get('heading_title');



		$data['text_enabled'] = $this->language->get('text_enabled');

		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['text_spicepay'] = $this->language->get('text_spicepay');

		$data['text_card'] = $this->language->get('text_card');

		$data['text_yes'] = $this->language->get('text_yes');

		$data['text_no'] = $this->language->get('text_no');

		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_result_url'] = $this->language->get('text_result_url');

		$data['text_success_url'] = $this->language->get('text_success_url');

		$data['text_fail_url'] = $this->language->get('text_fail_url');

		$data['text_save_and_stay'] = $this->language->get('text_save_and_stay');

		

		

		$data['entry_login'] = $this->language->get('entry_login');

		$data['entry_spicepay_key'] = $this->language->get('entry_spicepay_key');

		



		// URL

		$data['copy_result_url'] 	= HTTP_CATALOG . 'index.php?route=payment/spicepay/callback';

		$data['copy_success_url']	= HTTP_CATALOG . 'index.php?route=checkout/success';

		$data['copy_fail_url'] 	= HTTP_CATALOG . 'index.php?route=checkout/failure';



		



		$data['entry_order_status'] = $this->language->get('entry_order_status');

		$data['entry_currency'] = $this->language->get('entry_currency');

		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_sort_order'] = $this->language->get('entry_sort_order');



		$data['button_save'] = $this->language->get('button_save');

		$data['button_cancel'] = $this->language->get('button_cancel');



		$data['tab_general'] = $this->language->get('tab_general');



		//

	

		if (isset($this->error['warning'])) {

			$data['error_warning'] = $this->error['warning'];

		} else {

			$data['error_warning'] = '';

		}



		//

		if (isset($this->error['login'])) {

			$data['error_login'] = $this->error['login'];

		} else {

			$data['error_login'] = '';

		}



		if (isset($this->error['password1'])) {

			$data['error_password1'] = $this->error['password1'];

		} else {

			$data['error_password1'] = '';

		}





		

		$data['action'] = $this->url->link('extension/payment/spicepay', 'user_token=' . $this->session->data['user_token'], true);

		$data['update'] = $this->url->link('extension/payment/spicepay', 'user_token=' . $this->session->data['user_token'], true);



		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);



		$data['breadcrumbs'] = array();



   		$data['breadcrumbs'][] = array(

       		'text'      => $this->language->get('text_home'),

			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),

      		'separator' => false

   		);



   		$data['breadcrumbs'][] = array(

       		'text'      => $this->language->get('text_payment'),

			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true),

      		'separator' => ' :: '

   		);



   		$data['breadcrumbs'][] = array(

       		'text'      => $this->language->get('heading_title'),

			'href'      => $this->url->link('extension/payment/spicepay', 'user_token=' . $this->session->data['user_token'], true),

      		'separator' => ' :: '

   		);





		//

		if (isset($this->request->post['payment_spicepay_login'])) {

			$data['payment_spicepay_login'] = $this->request->post['payment_spicepay_login'];

		} else {

			$data['payment_spicepay_login'] = $this->config->get('payment_spicepay_login');

		}





		//

		if (isset($this->request->post['payment_spicepay_key'])) {

			$data['payment_spicepay_key'] = $this->request->post['payment_spicepay_key'];

		} else {

			$data['payment_spicepay_key'] = $this->config->get('payment_spicepay_key');

		}



		

		if (isset($this->request->post['payment_spicepay_order_status_id'])) {

			$data['payment_spicepay_order_status_id'] = $this->request->post['payment_spicepay_order_status_id'];

		} else {

			$data['payment_spicepay_order_status_id'] = $this->config->get('payment_spicepay_order_status_id');

		}



		$this->load->model('localisation/order_status');



		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();



		if (isset($this->request->post['payment_spicepay_geo_zone_id'])) {

			$data['payment_spicepay_geo_zone_id'] = $this->request->post['payment_spicepay_geo_zone_id'];

		} else {

			$data['payment_spicepay_geo_zone_id'] = $this->config->get('payment_spicepay_geo_zone_id');

		}



		$this->load->model('localisation/geo_zone');



		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();



		if (isset($this->request->post['payment_spicepay_status'])) {

			$data['payment_spicepay_status'] = $this->request->post['payment_spicepay_status'];

		} else {

			$data['payment_spicepay_status'] = $this->config->get('payment_spicepay_status');

		}


		if (isset($this->request->post['payment_spicepay_currency'])) {

			$data['payment_spicepay_currency'] = $this->request->post['payment_spicepay_currency'];

		} else {

			$data['payment_spicepay_currency'] = $this->config->get('payment_spicepay_currency');

		}



		if (isset($this->request->post['payment_spicepay_sort_order'])) {

			$data['payment_spicepay_sort_order'] = $this->request->post['payment_spicepay_sort_order'];

		} else {

			$data['payment_spicepay_sort_order'] = $this->config->get('payment_spicepay_sort_order');

		}



	

		$data['header'] = $this->load->controller('common/header');

		$data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this->load->controller('common/footer');



		$this->response->setOutput($this->load->view('extension/payment/spicepay', $data));



	}



	protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/payment/spicepay')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}

		

		// if (!$this->request->post['payment_spicepay_login']) {

		// 	$this->error['login'] = $this->language->get('error_login');

		// }



		// if (!$this->request->post['payment_spicepay_key']) {

		// 	$this->error['password1'] = $this->language->get('error_password1');

		// }

		// return !$this->error;

		if (!$this->error) {

			return TRUE;

		} else {

			return FALSE;

		}

	}

}

?>