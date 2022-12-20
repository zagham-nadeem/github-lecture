<?php

class Routes {

    public function __construct() {

        $this->domain = SITE_URL;
        $this->search = SEARCH_PAGE;
        $this->properties = PROPERTIES_PAGE;
        $this->contact = CONTACT_PAGE;
        $this->blog = BLOG_PAGE;
        $this->privacy = PRIVACY_PAGE;
        $this->terms = TERMS_PAGE;
    }

// Assets

    public function image($src) {
        return $this->domain.'/images/'. $src;
    }

    public function assets_js($file) {
        return $this->domain.'/assets/js/'. $file;
    }

    public function assets_css($file) {
        return $this->domain.'/assets/css/'. $file;
    }

    public function assets_img($file) {
        return $this->domain.'/assets/img/'. $file;
    }

// Pages

    public function home() {
        return $this->domain;
    }

    public function error() {
        return $this->domain.'/error';
    }

    public function offline() {
        return $this->domain.'/offline';
    }

    public function admin() {
        return $this->domain.'/admin';
    }

    public function signin() {
        return $this->domain.'/signin';
    }

    public function signup() {
        return $this->domain.'/signup';
    }

    public function signout() {
        return $this->domain.'/signout';
    }

    public function forgot() {
        return $this->domain.'/forgot';
    }

    public function reset($array = NULL) {


        $url = $this->domain.'/reset';

        if (isset($array) && !empty($array)) {

                $url .= '?'.http_build_query($array) . "\n";
        }
        
        return $url;
    }

    public function print($id) {
        return $this->domain.'/print?id='.$id;
    }

    public function property($id, $slug) {
        return $this->domain.'/property/'.$id.'/'.$slug;
    }

    public function post($id, $slug) {
        return $this->domain.'/post/'.$id.'/'.$slug;
    }

    public function search() {

        if (!$this->search || !empty($this->search)) {
            return $this->domain.'/'.$this->search;
        }else{
            return null;
        }
    }

    public function contact() {

        if (!$this->contact || !empty($this->contact)) {
            return $this->domain.'/'.$this->contact;
        }else{
            return null;
        }
    }

    public function privacy() {

        if (!$this->privacy || !empty($this->privacy)) {
            return $this->domain.'/'.$this->privacy;
        }else{
            return null;
        }
    }

    public function terms() {

        if (!$this->terms || !empty($this->terms)) {
            return $this->domain.'/'.$this->terms;
        }else{
            return null;
        }
    }

    public function blog($array = NULL) {

        if (!$this->blog || !empty($this->blog)) {

        $url = $this->domain.'/'.$this->blog;

        if (isset($array) && !empty($array)) {

                $url .= '?'.http_build_query($array) . "\n";
        }

        return $url;

        }else{
            return null;
        }
    }

    public function properties($array = NULL) {

        if (!$this->properties || !empty($this->properties)) {

        $url = $this->domain.'/'.$this->properties;

        if (isset($array) && !empty($array)) {

                $url .= '?'.http_build_query($array) . "\n";
        }

        return $url;

        }else{
            return null;
        }

    }

    public function page($slug) {

        if (!$slug || !empty($slug)) {
            return $this->domain.'/'.$slug;
        }else{
            return null;
        }
    }

    public function profile($action = NULL) {

        if ($action) {
            return $this->domain.'/profile?action='.$action;
        }else{
            return $this->domain.'/profile';
        }
    }

}

?>