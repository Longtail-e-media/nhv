<?php 
// Load the Google API PHP Client Library.
require_once LIB_PATH."/google/vendor/autoload.php"; 

class googleApi
{	
	protected $_view;
	protected $_json;
	protected $_start;
	protected $_end;
	protected $analytics;

	public function __construct()
    {
        $this->_view = '136030302';
        $this->_json = 'summit-hotel-ca25b7a1e943.json';
        $this->_start = date('Y-m-d', strtotime("-6 days"));
        $this->_end = date('Y-m-d');
        $this->analytics = $this->initializeAnalytics();
    }

	public function analytics_total()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Metrics object.
		$users = new Google_Service_AnalyticsReporting_Metric();
		$users->setExpression('ga:users');
		$users->setAlias('users');

		// 
		$nusers = new Google_Service_AnalyticsReporting_Metric();
		$nusers->setExpression('ga:newUsers');
		$nusers->setAlias('newUsers');

		// 
		$sessions = new Google_Service_AnalyticsReporting_Metric();
		$sessions->setExpression("ga:sessions");
		$sessions->setAlias("sessions");				

		// 
		$pageview = new Google_Service_AnalyticsReporting_Metric();
		$pageview->setExpression('ga:pageviews');
		$pageview->setAlias('pageviews');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setMetrics(array($users, $nusers, $sessions, $pageview));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->totals)) {
				foreach($result->reports[0]->data->totals as $row) {
					$resArr = $row->values;
				}
			}
		}

		return $resArr;
	}

	public function analytics_days()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Dimensions object.
		$gdate = new Google_Service_AnalyticsReporting_Dimension();
		$gdate->setName('ga:date');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setDimensions(array($gdate));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->rows)) {
				foreach($result->reports[0]->data->rows as $row) {
					$key = !empty($row->dimensions[0])?$row->dimensions[0]:'';
					$val = !empty($row->metrics[0]->values[0])?$row->metrics[0]->values[0]:'';
					$resArr['date'][] = date('M d', strtotime($key));
					$resArr['total'][] = $val;
				}
			}
		}

		return $resArr;	
	}

	public function analytics_country()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Dimensions object.
		$country = new Google_Service_AnalyticsReporting_Dimension();
		$country->setName('ga:country');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setDimensions(array($country));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->rows)) {
				foreach($result->reports[0]->data->rows as $row) {
					$key = !empty($row->dimensions[0])?$row->dimensions[0]:'';
					$val = !empty($row->metrics[0]->values[0])?$row->metrics[0]->values[0]:'';
					$resArr[$key] = $val;
				}
			}
		}

		return $resArr;	
	}

	public function analytics_browser()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Dimensions object.
		$browser = new Google_Service_AnalyticsReporting_Dimension();
		$browser->setName('ga:browser');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setDimensions(array($browser));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->rows)) {
				foreach($result->reports[0]->data->rows as $row) {
					$key = !empty($row->dimensions[0])?$row->dimensions[0]:'';
					$val = !empty($row->metrics[0]->values[0])?$row->metrics[0]->values[0]:'';
					$resArr[$key] = $val;
				}
			}
		}

		return $resArr;	
	}

	public function analytics_opsystem()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Dimensions object.
		$operating = new Google_Service_AnalyticsReporting_Dimension();
		$operating->setName('ga:operatingSystem');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setDimensions(array($operating));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->rows)) {
				foreach($result->reports[0]->data->rows as $row) {
					$key = !empty($row->dimensions[0])?$row->dimensions[0]:'';
					$val = !empty($row->metrics[0]->values[0])?$row->metrics[0]->values[0]:'';
					$resArr[$key] = $val;
				}
			}
		}

		return $resArr;		
	}

	public function analytics_pages()
	{
		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($this->_start);
		$dateRange->setEndDate($this->_end);

		// Create the Dimensions object.
		$pages = new Google_Service_AnalyticsReporting_Dimension();
		$pages->setName('ga:pagePath');

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($this->_view);
		$request->setDateRanges($dateRange);
		$request->setDimensions(array($pages));

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );
		$result = $this->analytics->reports->batchGet( $body );

		// 
		$resArr = array();		
		if(!empty($result)) {
			if(!empty($result->reports[0]->data->rows)) {
				foreach($result->reports[0]->data->rows as $row) {
					$key = !empty($row->dimensions[0])?$row->dimensions[0]:'';
					$val = !empty($row->metrics[0]->values[0])?$row->metrics[0]->values[0]:'';
					$resArr['title'][] = $key;
					$resArr['total'][] = $val;
				}
			}
		}

		return $resArr;		
	}

	private function initializeAnalytics()
	{
		$KEY_FILE_LOCATION = LIB_PATH.'/google/json/'.$this->_json;

		// Create and configure a new client object.
		$client = new Google_Client();
		$client->setApplicationName("Synhwak Google Analytics");
		$client->setAuthConfig($KEY_FILE_LOCATION);
		$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
		$analytics = new Google_Service_AnalyticsReporting($client);

		return $analytics;
	}
}

$google = new googleApi(); 
$gapi =& $google; 