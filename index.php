<?php
// include library
//include_once('../../../../simplehtmldom_2_0-RC2/simple_html_dom.php');

// directory of html files
$path = "../html/";
$files = scandir($path);

// output directory
$out = '../';
//$files = glob("*.{html}", GLOB_BRACE);

foreach ($files as $file) {
	//echo $file;
	if(pathinfo( $file, PATHINFO_EXTENSION ) == 'html') {


		$filename = pathinfo( $file)['filename'].'.php';
		$tags = get_meta_tags($path.$file);

		$html = file_get_html($path.$file);

		$title = $html->find('title',0)->innertext;
		$keywords = $tags['keywords'];
		$description = $tags['description'];

		$header = '<?php $title="'.$title.'";$keywords="'.$keywords.'";$description="'.$description.'";require("./header.php");?>';
		$content = $html->find('.content', 0)->innertext;
		$footer = "<?include_once('./footer.php')?>";
		$str = $header.$content.$footer;

		$fp = fopen($out.$filename, "w");
		fwrite($fp, $str);
		fclose($fp);
	}

}
