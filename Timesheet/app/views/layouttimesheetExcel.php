<?
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=".$this->filename);
header("Pragma: no-cache");
header("Expires: 0");
?>
<?
$this->content();
?>