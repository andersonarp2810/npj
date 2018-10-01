<?php
	//TechWorld3g - Please Support Us <3
	//Facebook : https://www.facebook.com/TechWorld3g
	//Twitter : https://twitter.com/TechWorld3g
	//Youtube : https://www.youtube.com/user/TechWorld3g
	//Blog : https://tech-world3g.blogspot.com
	//Donate : https://imraising.tv/u/techworld3g﻿

	include 'exportpdf.php';

	//--------------------------//

	if((isset($_POST['content'])) && (!empty(trim($_POST['content'])))) //if content of CKEditor ISN'T empty
	{
	//	echo "deu certo";
		$posted_editor = trim($_POST['content']); //get content of CKEditor
		$path = "files/".$_POST['description']."-".$_POST['idPetition'].".pdf"; //specify the file save location and the file name

		if(exportPDF($posted_editor,$path)) //exportPDF function returns TRUE
		{
			echo "File has been successfully exported!";
			header("Content-Disposition: attachment; filename=".basename($path)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
      readfile($path); // lê o arquivo
      exit; // aborta pós-ações

		}
		else //exportPDF function returns FALSE
		{
			echo "Failed to export the pdf file!";
		}

	}
	else //if content of CKEditor IS empty
	{
		echo "Error : Empty content!";
	}
