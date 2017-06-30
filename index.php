<?php

// Folder that contains the Salesforce PHP Toolkit
const SOAP_CLIENT_BASEDIR =  "./soapclient";
require_once (SOAP_CLIENT_BASEDIR.'/SforceEnterpriseClient.php');

class SalesforceSOAPClient
{
  const SALESFORCE_USER = 'your@salesforce.com';
  const SALESFORCE_PASS = 'jasdkfajdlfk';

  public function get_email_message()
  {
    $client = $this->create_salesforce_client();
    return $self->query_salesforce($client);
  }

  private function create_salesforce_client()
  {
    $mySforceConnection = new SforceEnterpriseClient();
    $mySoapClient = $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR.'/enterprise.wsdl.xml');
    $mylogin = $mySforceConnection->login(SALESFORCE_USER, SALESFORCE_PASS);
    return $mySforceConnection;
  }

  private function query_salesforce(SforceEnterpriseClient $mySforceConnection)
  {
    $query = 'SELECT Id, ActivityId, Headers, MessageIdentifier, ParentId, Status from EmailMessage';
    $response = $mySforceConnection->query(($query));
    $records = $response->records;

    $add_space = function($carry, $record) {
      $new_carry = $carry . $record . '<br>';
      return $new_carry;
    };

    return array_reduce($records, $add_space, '');
  }
}


try {
  $client = new SalesforceSOAPClient();
  $result = $client->get_email_message();
  return var_dump($result);
} catch (Exception $e) {
  throw $e;
}
