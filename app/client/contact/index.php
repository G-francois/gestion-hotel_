<?php

include('./app/commum/header_client.php');
?>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact mt-5">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Contact</h2>
                <p>Nous Contacter</p>
            </div>
        </div>

        <div class="container mb-5" data-aos="fade-up">
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Emplacement :</h4>
                            <p>A108 Adam Street, NY 535022, BENIN</p>
                        </div>


                        <div class="open-hours">
                            <i class="bi bi-clock"></i>
                            <h4>Heures d'Ouverture :</h4>
                            <p>
                                Du lundi - dimanche:<br/>
                                24H / 24H
                            </p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>slescocotiers@gmail.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>+229 62929439</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mt-5 mt-lg-0">
					<?php
					// Vérifie s'il y a un message de succès global à afficher
					if (!empty($_SESSION['contact-message-success-global'])) {
						?>
                        <div class="alert alert-primary"
                             style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
							<?= $_SESSION['contact-message-success-global'] ?>
                        </div>
						<?php
					}
					?>

					<?php
					// Vérifie s'il y a un message d'erreur global à afficher
					if (!empty($_SESSION['contact-message-erreur-global'])) {
						?>
                        <div class="alert alert-primary"
                             style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
							<?= $_SESSION['contact-message-erreur-global'] ?>
                        </div>
						<?php
					}
					?>

                    <form action="<?= PATH_PROJECT ?>client/contact/traitement-contact" method="post"
                          class="php-email-form">
						<?php
						if (!check_if_user_connected_client()) {
							?>
                            <div class="row">
                                <!-- Le champ nom -->
                                <div class="col-md-4 mb-3">
                                    <label for="inscription-nom">
                                        Nom :
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="nom" id="inscription-nom" class="form-control"
                                           placeholder="Veuillez entrer votre nom"
                                           value="<?= (!empty($donnees["nom"])) ? $donnees["nom"] : ''; ?>"
                                           required>
									<?php if (!empty($erreurs["nom"])) { ?>
                                        <span class="text-danger">
                    <?php echo $erreurs["nom"]; ?>
                  </span>
									<?php } ?>
                                </div>

                                <!-- Le champ prénom -->
                                <div class="col-md-4 mb-3">
                                    <label for="inscription-prenom">
                                        Prénom(s):
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" name="prenom" id="inscription-prenom" class="form-control"
                                           placeholder="Veuillez entrer vos prénoms"
                                           value="<?= (!empty($donnees["prenom"])) ? $donnees["prenom"] : ''; ?>"
                                           required>
									<?php if (!empty($erreurs["prenom"])) { ?>
                                        <span class="text-danger">
                    <?php echo $erreurs["prenom"]; ?>
                  </span>
									<?php } ?>
                                </div>

                                <!-- Le champ email -->
                                <div class="col-md-4 mb-3">
                                    <label for="inscription-email">
                                        Adresse mail :
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="email" name="email" id="inscription-email" class="form-control"
                                           placeholder="Veuillez entrer votre adresse mail"
                                           value="<?= (!empty($donnees["email"])) ? $donnees["email"] : ''; ?>"
                                           required>
									<?php if (!empty($erreurs["email"])) { ?>
                                        <span class="text-danger">
                    <?php echo $erreurs["email"]; ?>
                  </span>
									<?php } ?>
                                </div>

                            </div>
							<?php
						}
						?>

                        <!-- Le champ sujet du message-->
                        <div class="form-group mt-3">
                            <label for="inscription-subject">
                                Sujet du message :
                                <span class="text-danger">(*)</span>
                            </label>
                            <input type="text" class="form-control" name="subject" id="inscription-subject"
                                   placeholder="Veuillez entrer le sujet du message"
                                   value="<?= (!empty($donnees["subject"])) ? $donnees["subject"] : ''; ?>"
                                   required/>
							<?php if (!empty($erreurs["subject"])) { ?>
                                <span class="text-danger">
                <?php echo $erreurs["subject"]; ?>
              </span>
							<?php } ?>
                        </div>

                        <!-- Le champ message-->
                        <div class="form-group mt-3">
                            <label for="inscription-corps">
                                Corps du message :
                                <span class="text-danger">(*)</span>
                            </label>
                            <textarea class="form-control" id="inscription-corps" name="message" rows="8" placeholder="Veuillez entrer votre message" value="<?= (!empty($donnees["message"])) ? $donnees["message"] : ''; ?>" required></textarea>
							<?php if (!empty($erreurs["message"])) { ?>
                                <span class="text-danger">
                <?php echo $erreurs["message"]; ?>
              </span>
							<?php } ?>
                        </div>
                        <!-- <div class="my-3">
						  <div class="loading">Loading</div>
						  <div class="error-message"></div>
						  <div class="sent-message">
							Your message has been sent. Thank you!
						  </div>
						</div> -->
                        <div class="text-center">
                            <button type="submit" name="envoyer">Envoyer Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div data-aos="fade-up">
            <iframe style="border: 0; width: 100%; height: 450px; padding: 30px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15860.736835513524!2d2.4109918499999994!3d6.37020235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sbj!4v1712935871187!5m2!1sfr!2sbj"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <!-- <iframe style="border: 0; width: 100%; height: 450px; padding: 30px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe> -->
        </div>

    </section>
    <!-- End Contact Section -->

<?php
unset($_SESSION['erreurs-contact'], $_SESSION['donnees-contact'], $_SESSION['contact-message-success-global'], $_SESSION['contact-message-erreur-global']);
?>

<?php

include('./app/commum/footer_client_icm.php');
?>