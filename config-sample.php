<?php
// DB
define("HOST_DB",  "localhost");
define("USER_DB",  "root");
define("PASS_DB",  "root");
define("NAME_DB",  "projeto_integrador");

// APP
define("PAGE_SIZE",  10);
define("PROJECT_START_YEAR",  2014);

$extensions = array('jpg','jpeg','png','xls','xlsx','doc','docx','pdf', 'ppt','pptx', 'pps','ppsx', 'rar', 'zip');
define("ARQUIVO_EXTENSIONS",  serialize($extensions));

$mimes = array(
				'image/jpeg', // jpg, jpeg
				'image/png', // png
				'application/vnd.ms-excel', // xls
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
				'application/msword', // doc
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
				'application/pdf', // pdf
				'application/vnd.ms-powerpoint', // ppt, pps pot
				'application/vnd.openxmlformats-officedocument.presentationml.presentation', // pptx
				'application/vnd.openxmlformats-officedocument.presentationml.slideshow', // ppsx
				'application/x-rar-compressed', // rar
				'application/zip' // zip
			);
define("ARQUIVO_MIMES",  serialize($mimes));