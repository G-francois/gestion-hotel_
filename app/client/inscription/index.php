<?php
$include_icm_header = true;
include('./app/commum/header_.php');
?>


<div class="container" style="color: black;">

	<div class="card o-hidden border-0 shadow-lg" style="margin-top: 5rem; margin-bottom: 5rem;">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col-lg-6 d-none d-lg-block bg-register-image"></div>
				<div class="col-lg-6">
					<div class="p-5">

						<?php
						if (isset($_SESSION['inscription-message-success-global']) && !empty($_SESSION['inscription-message-success-global'])) {
						?>
							<div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
								<?= $_SESSION['inscription-message-success-global'] ?>
							</div>
						<?php
						}
						?>

						<?php
						if (isset($_SESSION['inscription-message-erreur-global']) && !empty($_SESSION['inscription-message-erreur-global'])) {
						?>
							<div class="alert alert-primary" style="color: white; background-color: #490303; border-color: snow;">
								<?= $_SESSION['inscription-message-erreur-global'] ?>
							</div>
						<?php
						}
						?>

						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">Créez un compte Client!</h1>
						</div>

						<form action="<?= PATH_PROJECT ?>client/inscription/traitement" method="post" class="user">
							<!-- Le champ nom -->
							<div class="form-group">
								<label for="inscription-nom">
									Nom:
									<span class="text-danger">(*)</span>
								</label>
								<input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer votre nom" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ''; ?>" required>
								<?php if (isset($erreurs["nom"]) && !empty($erreurs["nom"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["nom"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ prénom -->
							<div class="form-group">
								<label for="inscription-prenom">
									Prénoms:
									<span class="text-danger">(*)</span>
								</label>
								<input type="text" name="prenom" id="inscription-prenom" class="form-control" placeholder="Veuillez entrer vos prénoms" value="<?= (isset($donnees["prenom"]) && !empty($donnees["prenom"])) ? $donnees["prenom"] : ''; ?>" required>
								<?php if (isset($erreurs["prenom"]) && !empty($erreurs["prenom"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["prenom"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ téléphone -->
							<!-- <div class="form-group">
								<label for="inscription-telephone">
									Téléphone:
									<span class="text-danger">(*)</span>
								</label>
								<input type="text" name="telephone" id="inscription-telephone" class="form-control" placeholder="Veuillez entrer votre numéro de téléphone" value="<?= (isset($donnees["telephone"]) && !empty($donnees["telephone"])) ? $donnees["telephone"] : ''; ?>" required>
								<?php if (isset($erreurs["telephone"]) && !empty($erreurs["telephone"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["telephone"]; ?>
									</span>
								<?php } ?>
							</div> -->

							<!-- Le champ email -->
							<div class="form-group">
								<label for="inscription-email">
									Adresse mail:
									<span class="text-danger">(*)</span>
								</label>
								<input type="email" name="email" id="inscription-email" class="form-control" placeholder="Veuillez entrer votre adresse mail" value="<?= (isset($donnees["email"]) && !empty($donnees["email"])) ? $donnees["email"] : ''; ?>" required>
								<?php if (isset($erreurs["email"]) && !empty($erreurs["email"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["email"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ nom d'utilisateur -->
							<div class="form-group">
								<label for="inscription-nom-utilisateur">
									Nom d'utilisateur:
									<span class="text-danger">(*)</span>
								</label>
								<input type="text" name="nom-utilisateur" id="inscription-nom-utilisateur" class="form-control" placeholder="Veuillez entrer votre nom d'utilisateur" value="<?= (isset($donnees["nom-utilisateur"]) && !empty($donnees["nom-utilisateur"])) ? $donnees["nom-utilisateur"] : ''; ?>" required>
								<?php if (isset($erreurs["nom-utilisateur"]) && !empty($erreurs["nom-utilisateur"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["nom-utilisateur"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ mot de passe -->
							<div class="form-group">
								<label for="inscription-mot-passe">
									Mot de passe:
									<span class="text-danger">(*)</span>
								</label>
								<input type="password" name="mot-passe" id="inscription-mot-passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="<?= (isset($donnees["mot-passe"]) && !empty($donnees["mot-passe"])) ? $donnees["mot-passe"] : ''; ?>" required>
								<?php if (isset($erreurs["mot-passe"]) && !empty($erreurs["mot-passe"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["mot-passe"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ retapez mot de passe -->
							<div class="form-group">
								<label for="inscription-retapez-mot-passe">
									Retaper mot de passe:
									<span class="text-danger">(*)</span>
								</label>
								<input type="password" name="retapez-mot-passe" id="inscription-retapez-mot-passe" class="form-control" placeholder="Veuillez retaper votre mot de passe" value="<?= (isset($donnees["retapez-mot-passe"]) && !empty($donnees["retapez-mot-passe"])) ? $donnees["retapez-mot-passe"] : ''; ?>" required>
								<?php if (isset($erreurs["retapez-mot-passe"]) && !empty($erreurs["retapez-mot-passe"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["retapez-mot-passe"]; ?>
									</span>
								<?php } ?>
							</div>

							<!-- Le champ terms et conditions -->
							<div class="form-group">
								<div class="custom-control custom-checkbox small">
									<input type="checkbox" class="custom-control-input" name="termes-conditions" id="customCheck" required>
									<label class="custom-control-label" for="customCheck" style="color: blue; font-size: large;">
										J'accepte les termes et conditions
										<span class="text-danger">(*)</span>
									</label>
								</div>
								<?php if (isset($erreurs["termes-conditions"]) && !empty($erreurs["termes-conditions"])) { ?>
									<span class="text-danger">
										<?php echo $erreurs["termes-conditions"]; ?>
									</span>
								<?php } ?>
							</div>

							<button type="submit" class="btn btn-primary btn-block">Inscription</button>
						</form>
						<hr>
						<div class="text-center">
							<a class="small" href="<?= PATH_PROJECT ?>client/mot_de_passe">
								Mot de passe oublié ?
							</a>
						</div>
						<div class="text-center">
							<a class="small" href="<?= PATH_PROJECT ?>client/connexion">
								Vous avez déjà un compte ? Connectez-vous!
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php
unset($_SESSION['donnees-utilisateur'], $_SESSION['inscription-erreurs'], $_SESSION['inscription-message-success-global'], $_SESSION['inscription-message-erreur-global']);
?>

<?php
$include_icm_footer = true;
include('./app/commum/footer_.php');
?>