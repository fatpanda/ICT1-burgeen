<?php
class PayPalAdaptivePaymentsGateway {
  
  public function __construct() {
    $this->headers = array(
      'X-PAYPAL-SECURITY-USERID: ' . epap_api_credentials('api_username'),
      'X-PAYPAL-SECURITY-PASSWORD: ' . epap_api_credentials('api_password'),
      'X-PAYPAL-SECURITY-SIGNATURE: ' . epap_api_credentials('api_signature'),
      'X-PAYPAL-REQUEST-DATA-FORMAT: JSON',
      'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
      'X-PAYPAL-APPLICATION-ID: ' . epap_api_credentials('app_id')
    );
    $this->envelope = array(
      'errorLanguage' => 'en_US',
      'detailLevel' => 'returnAll'
    );
  }
  
  public function get_preapproval_details($preapproval_key) {
    $response = false;
    $create_packet = array(
      'preapprovalKey'  => $preapproval_key,
      'requestEnvelope' => $this->envelope
    );
    $response = $this->_paypal_send( $create_packet, 'PreapprovalDetails' );
    return $response;
  }
  
  public function pay_preapprovals($payment_id, $preapproval_key, $sender_email, $amount, $receivers=null) {
    global $edd_options;
    $response = false;
    $receivers = isset( $receivers ) ? $receivers : apply_filters( 'edap_adaptive_receivers', $edd_options['epap_receivers'] );
    $receivers = $this->divide_total( $receivers, $amount );
    $create_packet = array(
      'actionType'         => 'PAY',
      'preapprovalKey'     => $preapproval_key,
      'senderEmail'        => $sender_email,
      'clientDetails'      => array( 'applicationId' => epap_api_credentials('app_id'), 'ipAddress' => $_SERVER['SERVER_ADDR'] ),
      'feesPayer'          => isset( $edd_options['epap_fees'] ) ? $edd_options['epap_fees'] : 'EACHRECEIVER',
      'currencyCode'       => $edd_options['currency'],
      'receiverList'       => array( 'receiver' => $receivers ),
      'returnUrl'          => get_permalink( $edd_options['success_page'] ),
      'cancelUrl'          => function_exists( 'edd_get_failed_transaction_uri' ) ? edd_get_failed_transaction_uri() : get_permalink( $edd_options['purchase_page'] ),
      'ipnNotificationUrl' => trailingslashit( home_url() ) . '?ipn=epap&payment_id=' . $payment_id,
      'requestEnvelope'    => $this->envelope
    );
    $response = $this->_paypal_send( $create_packet, 'Pay' );
    return $response;
  }
  
  public function cancel_preapprovals($preapproval_key) {
    $create_packet = array(
      'requestEnvelope' => $this->envelope,
      'preapprovalKey'  => $preapproval_key
    );
    $response = $this->_paypal_send( $create_packet, 'CancelPreapproval' );
    return $response;
  }
  
  public function preapproval($payment_id, $amount, $starting_date=null, $ending_date=null) {
    global $edd_options;
    $create_packet = array(
      'clientDetails'               => array( 'applicationId' => epap_api_credentials('app_id'), 'ipAddress' => $_SERVER['SERVER_ADDR'] ),
      'currencyCode'                => $edd_options['currency'],
      'returnUrl'                   => get_permalink( $edd_options['success_page'] ),
      'cancelUrl'                   => function_exists( 'edd_get_failed_transaction_uri' ) ? edd_get_failed_transaction_uri() : get_permalink( $edd_options['purchase_page'] ),
      'ipnNotificationUrl'          => trailingslashit( home_url() ) . '?ipn=epap&payment_id=' . $payment_id,
      'requestEnvelope'             => $this->envelope,
      'startingDate'                => isset($starting_date) ? $starting_date : apply_filters( 'epap_preapproval_start_date', date( 'c' ) ),
      'endingDate'                  => isset($ending_date) ? $ending_date : apply_filters( 'epap_preapproval_end_date', date( 'c', time() + 365*86400 ) ),
      'maxAmountPerPayment'         => floatval( $amount ),
      'maxTotalAmountOfAllPayments' => floatval( $amount ),
      'maxNumberOfPayments'         => 1,
      'maxNumberOfPaymentsPerPeriod' => 1
    );
    $response = $this->_paypal_send( $create_packet, 'Preapproval' );
    return $response;
  }
  
  public function pay($payment_id, $receivers) {
    global $edd_options;
    $create_packet = array(
      'actionType'         => 'CREATE',
      'clientDetails'      => array( 'applicationId' => epap_api_credentials('app_id'), 'ipAddress' => $_SERVER['SERVER_ADDR'] ),
      'feesPayer'          => isset( $edd_options['epap_fees'] ) ? $edd_options['epap_fees'] : 'EACHRECEIVER',
      'currencyCode'       => $edd_options['currency'],
      'receiverList'       => array( 'receiver' => $receivers ),
      'returnUrl'          => get_permalink( $edd_options['success_page'] ),
      'cancelUrl'          => function_exists( 'edd_get_failed_transaction_uri' ) ? edd_get_failed_transaction_uri() : get_permalink( $edd_options['purchase_page'] ),
      'ipnNotificationUrl' => trailingslashit( home_url() ) . '?ipn=epap&payment_id=' . $payment_id,
      'requestEnvelope'    => $this->envelope
    );
    $pay_response = $this->_paypal_send( $create_packet, 'Pay' );
    $responsecode = strtoupper( $pay_response['responseEnvelope']['ack'] );
    if(($responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING')) {
      $set_response = $this->set_payment_options($pay_response['payKey']);
      $responsecode = strtoupper( $set_response['responseEnvelope']['ack'] );
      //if(($responsecode == 'SUCCESS' || $responsecode == 'SUCCESSWITHWARNING')) {
      //  $execute_response = $this->execute_payment($pay_response['payKey']);
      //  return $execute_response;
      //}
      //else {
        return $pay_response;
      //}
    }
    else {
      return $pay_response;
    }
  }
  
  public function execute_payment($pay_key) {
    $packet = array(
      'requestEnvelope' => $this->envelope,
      'payKey' => $pay_key
    );
    return $this->_paypal_send($packet, 'ExecutePayment');
  }
  
  public function set_payment_options($pay_key) {
    $packet = array(
      'requestEnvelope' => $this->envelope,
      'payKey' => $pay_key,
      'senderOptions' => array(
        'referrerCode' => 'ArmorlightComputers_SP'
      )
    );
    return $this->_paypal_send($packet, 'SetPaymentOptions');
  }
  
  public function get_payment_details($pay_key) {
    $packet = array(
      'requestEnvelope' => $this->envelope,
      'payKey' => $pay_key
    );
    return $this->_paypal_send($packet, 'PaymentDetails');
  }
  
  public function get_payment_options($pay_key) {
    $packet = array(
      'requestEnvelope' => $this->envelope,
      'payKey' => $pay_key
    );
    
    return $this->_paypal_send($packet, 'GetPaymentOptions');
  }
  
  public function _paypal_send($data, $call) {
    
    //open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, epap_api_credentials('api_end_point') . $call);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $response;
    
  }
  
  public function divide_total($adaptive_receivers, $total) {
    global $edd_options;
    $receivers = array();
    if(!is_array($adaptive_receivers)) {
      $adaptive_receivers = explode("\n", $adaptive_receivers);
    }
    $total_receivers = count($adaptive_receivers);
    $new_total = 0;
    $cycle = 0;
    foreach($adaptive_receivers as $key => $receiver) {
      $cycle++;
      if(!is_array($receiver)) {
        $receiver = explode('|', $receiver);
      }
      $amount = round($total / 100 * trim($receiver[1]), 2);
      
      if(isset($edd_options['epap_payment_type']) && $edd_options['epap_payment_type'] == 'parallel') {
        $receivers[$key] = array(
          'email' => trim($receiver[0]),
          'amount' => $amount
        );
      }
      else {
        if($cycle == 1) {
          $receivers[$key] = array(
            'email' => trim($receiver[0]),
            'amount' => $total,
            'primary' => true
          );
        }
        else {
          $receivers[$key] = array(
            'email' => trim($receiver[0]),
            'amount' => $amount,
            'primary' => false
          );
        }
      }
      
      $new_total += $amount;
      if($cycle == $total_receivers) {
        if($new_total > $total) {
          $receivers[$key]['amount'] = $amount - ($new_total - $total);
        }
        elseif($total > $new_total) {
          $receivers[$key]['amount'] = $amount + ($total - $new_total);
        }
      }
    }
    
    return $receivers;
  }
  
}