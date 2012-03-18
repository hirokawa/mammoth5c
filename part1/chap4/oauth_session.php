  public function updateToken($time) {
    if ($time < $_SESSION['updated_time'] + $_SESSION['expires_in']) {
      return false;
    }
    $this->auth->setToken($_SESSION['token'], $_SESSION['token_secret']);
    $r = $this->auth->getAccessToken($this->entry['access_token'],
				     $_SESSION['session_handle']);
    if (isset($r['oauth_problem'])) {
      throw new RuntimeException($r['oauth_problem']);
    }
    $_SESSION['token'] = $r['oauth_token']; 
    $_SESSION['token_secret'] = $r['oauth_token_secret']; 
    $_SESSION['updated_time'] = time();   
    return true;
  }

  public function saveOpts($r) {
    if (isset($r['oauth_session_handle'])) {
      $_SESSION['session_handle'] = $r['oauth_session_handle'];
      $_SESSION['expires_in'] = $r['oauth_expires_in'];      
      $_SESSION['updated_time'] = time();
    }    
  }
