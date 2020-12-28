<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login - mybrary</title>

		<!-- <link rel="icon" href="img/favicon.ico"> -->
		<!-- CSS FILES -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/uikit@latest/dist/css/uikit.min.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body class="login uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-height-viewport uk-overflow-hidden uk-light" data-uk-height-viewport>

		<!-- overlay -->
		<div class="uk-position-cover uk-overlay-primary"></div>
		<!-- /overlay -->

		<div class="uk-position-bottom-center uk-position-small uk-visible@m uk-position-z-index">

			<span class="uk-text-small uk-text-muted">© 2020 by D.Sánchez - <a href="https://www.dsanchez.net/">www.dsanchez.net</a> | Published under the <a href="https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12" title="European General Public License" target="_blank" data-uk-tooltip>EUPL</a>
		</div>
		<div class="uk-width-medium uk-padding-small uk-position-z-index" uk-scrollspy="cls: uk-animation-fade">

			<div class="uk-text-center uk-margin">
				<img src="img/logo.svg" alt="Logo">
			</div>

			<!-- login -->
			<form method="post" class="toggle-class" action="index.php">
				<fieldset class="uk-fieldset">
					<div class="uk-margin-small">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
							<input class="uk-input uk-border-pill" required placeholder="Username" type="text" name="username">
						</div>
					</div>
					<div class="uk-margin-small">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
							<input class="uk-input uk-border-pill" required placeholder="Password" type="password" name="password">
						</div>
					</div>

					<div class="uk-margin-bottom">
						<button type="submit" class="uk-button uk-button-primary uk-border-pill uk-width-1-1">LOG IN</button>
					</div>
				</fieldset>
			</form>
			<!-- /login -->

			<!-- action buttons -->
			<div>
				<div class="uk-text-center">
					<!--<a class="uk-link-reset uk-text-small toggle-class" data-uk-toggle="target: .toggle-class ;animation: uk-animation-fade">Forgot your password?</a>-->
					<a class="uk-link-reset uk-text-small toggle-class" data-uk-toggle="target: .toggle-class ;animation: uk-animation-fade" hidden><span data-uk-icon="arrow-left"></span> Back to Login</a>
				</div>
			</div>
			<!-- action buttons -->
		</div>

		<!-- JS FILES -->
		<script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit-icons.min.js"></script>
	</body>
</html>
