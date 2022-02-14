<?php  
    define( 'MAIL_TO', /* >>>>> */'morgane@foxy-creadesign.fr'/* <<<<< */ );  //ajouter votre courriel  
    define( 'MAIl_NAME', '' ); // valeur par défaut  
    define( 'MAIL_FROM', 'utilisateur@domaine.tld' ); // valeur par défaut  
    define( 'MAIL_OBJECT', 'objet du message' ); // valeur par défaut  
    define( 'MAIL_MESSAGE', 'votre message' ); // valeur par défaut  

	$mailSent = false; // drapeau qui aiguille l'affichage du formulaire OU du récapitulatif  
    $errors = array(); // tableau des erreurs de saisie  
      
    if( filter_has_var( INPUT_POST, 'send' ) ) // le formulaire a été soumis avec le bouton [Envoyer]  
    {  
        $name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );  
        if( $name === NULL || $name === MAIL_NAME ) // si le courriel fourni est vide OU égale à la valeur par défaut  
        {  
            $errors[] = 'Vous devez renseigner votre nom.';  
        }

        $from = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );  
        if( $from === NULL || $from === MAIL_FROM ) // si le courriel fourni est vide OU égale à la valeur par défaut  
        {  
            $errors[] = 'Vous devez renseigner votre adresse de courrier électronique.';  
        }  
        elseif( $from === false ) // si le courriel fourni n'est pas valide  
        {  
            $errors[] = 'L\'adresse de courrier électronique n\'est pas valide.';  
            $from = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );  
        }  

        $object = filter_input( INPUT_POST, 'subject', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW );  
        if( $object === NULL OR $object === false OR empty( $object ) OR $object === MAIL_OBJECT ) // si l'objet fourni est vide, invalide ou égale à la valeur par défaut  
        {  
            $errors[] = 'Vous devez renseigner l\'objet.';  
        }  

 /* pas besoin de nettoyer le message.   
 / [http://www.phpsecure.info/v2/article/MailHeadersInject.php]  
 / Logiquement, les parties message, To: et Subject: pourraient servir aussi à injecter quelque chose,  mais la fonction mail()  
 / filtre bien les deux dernières, et la première est le message, et à partir du moment où on a sauté une ligne dans l'envoi du mail,  
 / c'est considéré comme du texte; le message ne saurait donc rester qu'un message.*/  
        $message = filter_input( INPUT_POST, 'message', FILTER_UNSAFE_RAW );  
        if( $message === NULL OR $message === false OR empty( $message ) OR $message === MAIL_MESSAGE ) // si le message fourni est vide ou égale à la valeur par défaut  
        {  
            $errors[] = 'Vous devez écrire un message.';  
        }  

        if( count( $errors ) === 0 ) // si il n'y a pas d'erreurs  
        {  
            if( mail( MAIL_TO, $object, $message, "From: $name <$from>\nReply-to: $from\n" ) ) // tentative d'envoi du message  
            {  
                $mailSent = true;  
            }  
            else // échec de l'envoi  
            {  
                $errors[] = 'Votre message n\'a pas été envoyé.';  
            }  
        }  
    }  
    else // le formulaire est affiché pour la première fois, avec les valeurs par défaut  
    {  
		$from = MAIl_NAME; MAIL_FROM;  
        $object = MAIL_OBJECT;  
        $message = MAIL_MESSAGE;  
    }  
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Foxy CréaDesign, portfolio, bibliothèque de mes créations graphiques : livres, affiches, sites, kakemono, packaging, pochettes, carte de visite, livret, maquettage, maquettage web, responsive, logo, charte graphique, portefolio." />
	<meta name="keyword" content="Portfolio, création visuelle, graphisme, infographie, maquettage web, maquettage print, newsletter, identité visuelle, édition, marketing, packaging, mise en page, retouche, intégration html css, photoshop, illustrator, indesign" />
	<meta name="robots" content="index,follow" />
	<title>Contact - Foxy CreaDesign Portfolio - Infographisme, maquettage web et print, identité visuelle, proximité paris</title>
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/favicon/favicon.png" type="image/png">
	<link rel="icon" sizes="32x32" href="img/favicon/favicon-32.png" type="image/png">
	<link rel="icon" sizes="64x64" href="img/favicon/favicon-64.png" type="image/png">
	<link rel="icon" sizes="96x96" href="img/favicon/favicon-96.png" type="image/png">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,700,800,900i&amp;subset=cyrillic-ext,latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Megrim" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="lib/icones-foxy-crea-design/css/icon-foxy.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script src="js/formulaire-contact-foxy.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119900104-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-119900104-1');
	</script>
</head>
<body>
	<div class="container">
		<header>
			<h1 class="logo"><a href="index.html"><img src="img/logo/foxy/fox/foxycreadesign-designergraphique.png" alt="Foxy CréaDesign"></a></h1>
			<nav>
				<ul class="menu">
					<li class="navigation nav"><a href="index.html">Accueil</a></li>
					<li class="navigation  nav"><a href="qui.html">Qui suis-je ?</a></li>
					<li class="navigation portfolio"><a href="projets.html">Portfolio</a>
					</li>
					<li class="navigation nav"><a href="contact.php">Contactez-moi</a></li>
				</ul>
				<div class="clearfix"></div>
			</nav>
			<div class="clearfix"></div>
			<h2>Contactez-moi</h2>
			<div class="clearfix"></div>
		</header>
		<article class="page-contact">
			<div>
				<div class="formulaire">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3">
<?php  
    if( $mailSent === true ) // si le message a bien été envoyé, on affiche le récapitulatif  
    {  
?>  
        <p id="success">Votre message a bien été envoyé.</p>  
        <p><strong>Courriel pour la réponse :</strong><br /><?php echo( $from ); ?></p>  
        <p><strong>Objet :</strong><br /><?php echo( $object ); ?></p>  
        <p><strong>Message :</strong><br /><?php echo( nl2br( htmlspecialchars( $message ) ) ); ?></p>  
<?php  
    }  
    else // le formulaire est affiché pour la première fois ou le formulaire a été soumis mais contenait des erreurs  
    {  
        if( count( $errors ) !== 0 )  
        {  
            echo( "\t\t<ul>\n" );  
            foreach( $errors as $error )  
            {  
                echo( "\t\t\t<li>$error</li>\n" );  
            }  
            echo( "\t\t</ul>\n" );  
        }  
        else  
        {  
            echo( "\t\t<p id=\"welcome\"><em>Tous les champs sont obligatoires</em></p>\n" );  
        }  
?> 
				          <form id="contact-form" class="form" action="#" method="POST" >
				              <div class="form-group">
				                  <label class="form-label" for="name">Nom</label>
				                  <input type="text" class="form-control" id="name" name="name" placeholder="Votre nom" tabindex="1" required>
				              </div>                            
				              <div class="form-group">
				                  <label class="form-label" for="email">Mail</label>
				                  <input type="email" class="form-control" id="email" name="email" placeholder="Votre mail" tabindex="2" required>
				              </div>                            
				              <div class="form-group">
				                  <label class="form-label" for="subject">Objet</label>
				                  <input type="text" class="form-control" id="subject" name="subject" placeholder="Objet" tabindex="3">
				              </div>                            
				              <div class="form-group">
				                  <label class="form-label" for="message">Message</label>
				                  <textarea rows="5" cols="50" name="message" class="form-control" id="message" placeholder="Votre message..." tabindex="4" required></textarea>
				              </div>
				              <div class="text-center">
				                  <input  class="box btn-start-order btn" type="submit" name="send" value="Envoyer">
				              </div>
				          </form>
<?php  
	}  
?> 
						</div>
					</div>
				</div>
			</div>
		</article>
		<footer>
			<div class="footerleft">
				<div class="coordonnees">
					<div class="mail">
						<p class="footerleft adresse"><a href="mailto:morgane@foxy-creadesign.fr"><i class="icon-paper-plane"></i><br>Envoyez-moi un mail</a></p>
					</div>
					<div class="clearfix"></div>
					<div class="tel">
						<p class="footerleft telephone"><a href="callto:+33344010203"><i class="icon-mobile"></i><br>06 81 77 70 05</a></p>
					</div>
					<div class="btncontact">
					<p class="footerleft btncontact"><a href="contact.php"><i class="icon-linkedin"></i></a></p>
					</div>
				<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="center">
				<a href="index.html"><img src="img/logo/foxy/fox/foxycreadesignlogo.png" alt="Foxy CréaDesign"></a>
			</div>
			<div class="partenaires">
				<a class="adressepartenaires" href="partenaires.html">Partenaires</a>
				<ul>
					<li><a class="liens" href="http://www.amandine-portfolio.com/" target="_blank">AV</a></li>
					<li><a class="liens" href="http://sylvain-hernas-portfolio.fr/" target="_blank">Sylvain Hernas</a></li>
					<li><a class="liens" href="http://www.amandine-portfolio.com/" target="_blank">Pauline créa</a></li>
					<li><a class="liens" href="http://www.graphik-am.fr/" target="_blank">Graphik'am</a></li>
					<li><a class="liens" href="http://rmoinat.com/" target="_blank">Romain Moinat</a></li>
					<li><a class="liens" href="http://www.media-management.fr/" target="_blank">Media-management</a></li>
					<li><a class="liens" href="https://www.pierreandmarie.com/" target="_blank">Pierre and Marie</a></li>
					<li><a class="liens" href="https://white-rabbit.tech/" target="_blank">White Rabbit</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="copyright">© 2018
				<a href="www.foxy-creadesign.fr">Foxy CreaDesign</a> - <a href="plan.html">Plan du site</a> - <a href="mentions.html">Mentions légales</a></div>
		</footer>
	</div>
</body>
</html>