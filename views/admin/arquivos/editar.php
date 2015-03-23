<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('arquivo'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Arquivo();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Arquivos <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/arquivos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/arquivos/editar/'. $id) : $h->urlFor('admin/arquivos/editar'); ?>
    <form action="<?=$formAction?>" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Nome</label>
                    <input type="text" class="form-control required" id="nome" name="nome" value="<?=$registro->nome?>">
                </div>

                <div class="form-group">
                    <label for="caminho">Arquivo</label>
                    <input type="file" class="form-control required" id="caminho" name="caminho">
                    <div class="help-block">Extensões permitidas ( <?php echo implode(", ", unserialize(ARQUIVO_EXTENSIONS)) ?> ).</div>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
            </div>
        </div>
    </form>   

</div>

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['nome']) )
  {

    $arquivo = new Arquivo();
    $arquivo->id = $_POST['id'];
    $arquivo->nome = $_POST['nome'];

    $extensao = pathinfo($_FILES['caminho']['name'], PATHINFO_EXTENSION);

    if (!function_exists('mime_content_type')) {
    function mime_content_type($filename) {
    $idx = explode( '.', $filename );
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);
 
    $mimet = array( 
        'ai' =>'application/postscript',
    'aif' =>'audio/x-aiff',
    'aifc' =>'audio/x-aiff',
    'aiff' =>'audio/x-aiff',
    'asc' =>'text/plain',
    'atom' =>'application/atom+xml',
    'avi' =>'video/x-msvideo',
    'bcpio' =>'application/x-bcpio',
    'bmp' =>'image/bmp',
    'cdf' =>'application/x-netcdf',
    'cgm' =>'image/cgm',
    'cpio' =>'application/x-cpio',
    'cpt' =>'application/mac-compactpro',
    'crl' =>'application/x-pkcs7-crl',
    'crt' =>'application/x-x509-ca-cert',
    'csh' =>'application/x-csh',
    'css' =>'text/css',
    'dcr' =>'application/x-director',
    'dir' =>'application/x-director',
    'djv' =>'image/vnd.djvu',
    'djvu' =>'image/vnd.djvu',
    'doc' =>'application/msword',
    'dtd' =>'application/xml-dtd',
    'dvi' =>'application/x-dvi',
    'dxr' =>'application/x-director',
    'eps' =>'application/postscript',
    'etx' =>'text/x-setext',
    'ez' =>'application/andrew-inset',
    'gif' =>'image/gif',
    'gram' =>'application/srgs',
    'grxml' =>'application/srgs+xml',
    'gtar' =>'application/x-gtar',
    'hdf' =>'application/x-hdf',
    'hqx' =>'application/mac-binhex40',
    'html' =>'text/html',
    'html' =>'text/html',
    'ice' =>'x-conference/x-cooltalk',
    'ico' =>'image/x-icon',
    'ics' =>'text/calendar',
    'ief' =>'image/ief',
    'ifb' =>'text/calendar',
    'iges' =>'model/iges',
    'igs' =>'model/iges',
    'jpe' =>'image/jpeg',
    'jpeg' =>'image/jpeg',
    'jpg' =>'image/jpeg',
    'js' =>'application/x-javascript',
    'kar' =>'audio/midi',
    'latex' =>'application/x-latex',
    'm3u' =>'audio/x-mpegurl',
    'man' =>'application/x-troff-man',
    'mathml' =>'application/mathml+xml',
    'me' =>'application/x-troff-me',
    'mesh' =>'model/mesh',
    'mid' =>'audio/midi',
    'midi' =>'audio/midi',
    'mif' =>'application/vnd.mif',
    'mov' =>'video/quicktime',
    'movie' =>'video/x-sgi-movie',
    'mp2' =>'audio/mpeg',
    'mp3' =>'audio/mpeg',
    'mpe' =>'video/mpeg',
    'mpeg' =>'video/mpeg',
    'mpg' =>'video/mpeg',
    'mpga' =>'audio/mpeg',
    'ms' =>'application/x-troff-ms',
    'msh' =>'model/mesh',
    'mxu m4u' =>'video/vnd.mpegurl',
    'nc' =>'application/x-netcdf',
    'oda' =>'application/oda',
    'ogg' =>'application/ogg',
    'pbm' =>'image/x-portable-bitmap',
    'pdb' =>'chemical/x-pdb',
    'pdf' =>'application/pdf',
    'pgm' =>'image/x-portable-graymap',
    'pgn' =>'application/x-chess-pgn',
    'php' =>'application/x-httpd-php',
    'php4' =>'application/x-httpd-php',
    'php3' =>'application/x-httpd-php',
    'phtml' =>'application/x-httpd-php',
    'phps' =>'application/x-httpd-php-source',
    'png' =>'image/png',
    'pnm' =>'image/x-portable-anymap',
    'ppm' =>'image/x-portable-pixmap',
    'ppt' =>'application/vnd.ms-powerpoint',
    'ps' =>'application/postscript',
    'qt' =>'video/quicktime',
    'ra' =>'audio/x-pn-realaudio',
    'ram' =>'audio/x-pn-realaudio',
    'ras' =>'image/x-cmu-raster',
    'rdf' =>'application/rdf+xml',
    'rgb' =>'image/x-rgb',
    'rm' =>'application/vnd.rn-realmedia',
    'roff' =>'application/x-troff',
    'rtf' =>'text/rtf',
    'rtx' =>'text/richtext',
    'sgm' =>'text/sgml',
    'sgml' =>'text/sgml',
    'sh' =>'application/x-sh',
    'shar' =>'application/x-shar',
    'shtml' =>'text/html',
    'silo' =>'model/mesh',
    'sit' =>'application/x-stuffit',
    'skd' =>'application/x-koan',
    'skm' =>'application/x-koan',
    'skp' =>'application/x-koan',
    'skt' =>'application/x-koan',
    'smi' =>'application/smil',
    'smil' =>'application/smil',
    'snd' =>'audio/basic',
    'spl' =>'application/x-futuresplash',
    'src' =>'application/x-wais-source',
    'sv4cpio' =>'application/x-sv4cpio',
    'sv4crc' =>'application/x-sv4crc',
    'svg' =>'image/svg+xml',
    'swf' =>'application/x-shockwave-flash',
    't' =>'application/x-troff',
    'tar' =>'application/x-tar',
    'tcl' =>'application/x-tcl',
    'tex' =>'application/x-tex',
    'texi' =>'application/x-texinfo',
    'texinfo' =>'application/x-texinfo',
    'tgz' =>'application/x-tar',
    'tif' =>'image/tiff',
    'tiff' =>'image/tiff',
    'tr' =>'application/x-troff',
    'tsv' =>'text/tab-separated-values',
    'txt' =>'text/plain',
    'ustar' =>'application/x-ustar',
    'vcd' =>'application/x-cdlink',
    'vrml' =>'model/vrml',
    'vxml' =>'application/voicexml+xml',
    'wav' =>'audio/x-wav',
    'wbmp' =>'image/vnd.wap.wbmp',
    'wbxml' =>'application/vnd.wap.wbxml',
    'wml' =>'text/vnd.wap.wml',
    'wmlc' =>'application/vnd.wap.wmlc',
    'wmlc' =>'application/vnd.wap.wmlc',
    'wmls' =>'text/vnd.wap.wmlscript',
    'wmlsc' =>'application/vnd.wap.wmlscriptc',
    'wmlsc' =>'application/vnd.wap.wmlscriptc',
    'wrl' =>'model/vrml',
    'xbm' =>'image/x-xbitmap',
    'xht' =>'application/xhtml+xml',
    'xhtml' =>'application/xhtml+xml',
    'xls' =>'application/vnd.ms-excel',
    'xml xsl' =>'application/xml',
    'xpm' =>'image/x-xpixmap',
    'xslt' =>'application/xslt+xml',
    'xul' =>'application/vnd.mozilla.xul+xml',
    'xwd' =>'image/x-xwindowdump',
    'xyz' =>'chemical/x-xyz',
    'zip' =>'application/zip'
    );
 
    if (isset( $mimet[$idx] )) {
     return $mimet[$idx];
    } else {
     return 'application/octet-stream';
    }
    }
}

    if( !in_array(mime_content_type($_FILES['caminho']['tmp_name']), unserialize(ARQUIVO_MIMES) ) )
    {
        $h->addFlashMessage('error', 'Formato de arquivo inválido!');
        $h->redirectFor('admin/arquivos/editar');
    }

    $arquivo->caminho = strtolower('arquivos/'.str_replace(" ","-", $arquivo->nome).'-'.date("YmdHis").'.'.$extensao);

    if (move_uploaded_file($_FILES['caminho']['tmp_name'], 'web/admin/uploads/'.$arquivo->caminho)) {

        if( $_POST['id'] == '' )
        {
            $id = $c->nextID();
            $c->save($arquivo)->executeQuery();

            $h->addFlashMessage('success', 'Arquivo adicionado com sucesso!');
        }
        else
        {
            $c->clearQuery()->update($arquivo)->executeQuery();
            $id = $arquivo->id;

            $h->addFlashMessage('success', 'Arquivo alterado com sucesso!');
        }

        $h->redirectFor('admin/arquivos');

    }
    else
    {
        $h->addFlashMessage('error', 'Erro ao adicionar o arquivo!');
        $h->redirectFor('admin/arquivos/editar');
    }

  }

?>
