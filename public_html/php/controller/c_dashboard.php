<?php
require_once dirname(__FILE__) . '/../classes/Dashboard.php';
$dashboard = new Dashboard();

if (isset($_POST["get_information"])) {
            $dashboard->get_information();
}