<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer-info">
                        <h3>Sous les Cocotiers</h3>
                        <p>
                            A108 Adam Street <br />
                            NY 535022, BENIN<br /><br />
                            <strong>Phone:</strong> +229 62929439<br />
                            <strong>Email:</strong> <a href="#">slescocotiers@gmail.com</a><br />
                        </p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 footer-links">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="<?= PATH_PROJECT ?>client/acceuil">Accueil</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="<?= PATH_PROJECT ?>client/chambres">Chambres</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="<?= PATH_PROJECT ?>client/restaurant">Restaurant</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="<?= PATH_PROJECT ?>client/galeries">Galeries</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="<?= PATH_PROJECT ?>client/contact">Contact</a>
                        </li>

                        <?php
                        if (check_if_user_connected_client()) {
                        ?>

                            <li>
                                <i class="bx bx-chevron-right"></i>
                                <a href="<?= PATH_PROJECT ?>client/profil">Mon Profile</a>
                            </li>

                            <li>
                                <i class="bx bx-chevron-right"></i>
                                <a href="<?= PATH_PROJECT ?>client/liste_des_reservations">Liste des reservations</a>
                            </li>

                            <li>
                                <i class="bx bx-chevron-right"></i>
                                <a href="<?= PATH_PROJECT ?>client/liste_des_commandes">Liste des commandes</a>
                            </li>

                            <li>
                                <i class="bx bx-chevron-right"></i>
                                <a href="<?= PATH_PROJECT ?>client/liste_des_messages">Liste des messages</a>
                            </li>

                            <li>
                                <i class="bx bx-chevron-right"></i>
                                <a href="<?= PATH_PROJECT ?>client/deconnexion">Déconnexion</a>
                            </li>

                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>Sous Les Cocotiers</span></strong>. Tout Droit Reservé
        </div>
        <div class="credits">
            Designed by <a href="#">Franco Services</a>
        </div>
    </div>
</footer>
<!-- End Footer -->


<!-- Bootstrap core JavaScript-->
<script src="<?= PATH_PROJECT ?>public/outils/jquery/jquery.min.js"></script>
<script src="<?= PATH_PROJECT ?>public/js/bootstrap.min.js"></script>

<!-- <script src="<?= PATH_PROJECT ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="<?= PATH_PROJECT ?>public/outils/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= PATH_PROJECT ?>public/outils/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= PATH_PROJECT ?>public/js/sb-admin-2.js"></script>

<!-- Inclure Select2 JS -->
<script src="<?= PATH_PROJECT ?>public/outils/select2/js/select2.min.js"></script>


<script src="<?= PATH_PROJECT ?>public/outils/datatables/jquery.dataTables.js"></script>
<script src="<?= PATH_PROJECT ?>public/outils/datatables/dataTables.bootstrap4.js"></script>
<script src="<?= PATH_PROJECT ?>public/js/demo/datatables-demo.js"></script>


<!-- outils JS Files -->

<script src="<?= PATH_PROJECT ?>public/outils/aos/aos.js"></script>

<script src="<?= PATH_PROJECT ?>public/outils/glightbox/js/glightbox.min.js"></script>

<script src="<?= PATH_PROJECT ?>public/outils/isotope-layout/isotope.pkgd.min.js"></script>

<script src="<?= PATH_PROJECT ?>public/outils/swiper/swiper-bundle.min.js"></script>

<script src="<?= PATH_PROJECT ?>public/js/main.js"></script>

<script src="<?= PATH_PROJECT ?>public/vendor/jsPDF/jspdf.umd.min.js"></script>

<script src="<?= PATH_PROJECT ?>public/vendor/jsPDF-AutoTable/jspdf.plugin.autotable.min.js"></script>

<script>
    function convertNumberToWords(number) {
        const ones = ["", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf"];
        const teens = ["dix", "onze", "douze", "treize", "quatorze", "quinze", "seize", "dix-sept", "dix-huit", "dix-neuf"];
        const tens = ["", "dix", "vingt", "trente", "quarante", "cinquante", "soixante", "soixante", "quatre-vingt", "quatre-vingt"];
        const thousands = ["", "mille", "million", "milliard"];

        function convertLessThanThousand(num) {
            let word = "";
            if (num >= 100) {
                let hundreds = Math.floor(num / 100);
                word += (hundreds > 1 ? ones[hundreds] + " cent" : "cent");
                num %= 100;
                if (num > 0) word += " ";
            }
            if (num >= 10 && num <= 19) {
                word += teens[num - 10];
            } else if (num >= 20) {
                let ten = Math.floor(num / 10);
                word += tens[ten];
                if ((ten === 7 || ten === 9) && num % 10 !== 0) {
                    word += teens[num % 10];
                } else if (num % 10 > 0) {
                    word += (ten === 8 ? "-" : " ") + ones[num % 10];
                }
            } else {
                word += ones[num];
            }
            return word;
        }

        if (isNaN(number) || number < 0) return "Nombre invalide";

        let word = "";
        let partIndex = 0;
        do {
            let numPart = number % 1000;
            if (numPart > 0) {
                let prefix = convertLessThanThousand(numPart);
                if (partIndex > 0) {
                    prefix += " " + thousands[partIndex] + (numPart > 1 && partIndex === 1 ? "s" : "");
                }
                word = prefix + (word ? " " + word : "");
            }
            number = Math.floor(number / 1000);
            partIndex++;
        } while (number > 0);

        return word.trim();
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".generate-pdf").forEach(button => {
            button.addEventListener("click", function() {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                const numReservation = this.getAttribute("data-reservation");
                const reservationElement = document.getElementById("collapse" + numReservation);

                let y = 20;
                const pageWidth = doc.internal.pageSize.width;

                // 🏨 **Ajout du logo**
                const logo = "<?= PATH_PROJECT ?>public/images/al_copyrighter.png";
                doc.addImage(logo, "PNG", 10, 5, 35, 30);

                // 🏨 **En-tête de la facture**
                doc.setFont("Times", "bold");
                doc.setFontSize(18);
                doc.text("HÔTEL SOUS LES COCOTIERS", 105, 15, {
                    align: "center"
                });

                doc.setFontSize(12);
                doc.setFont("Times", "normal");
                doc.text("Adresse : A108 Adam Street NY 535022, BENIN", 105, 22, {
                    align: "center"
                });
                doc.text("Téléphone : +229 62929439", 105, 28, {
                    align: "center"
                });
                doc.text("Email : slescocotiers@gmail.com", 105, 34, {
                    align: "center"
                });

                // 📝 **Numéro de réservation**
                doc.setFontSize(16);
                doc.setFont("Times", "bold");
                doc.text("FACTURE DE RÉSERVATION N° " + numReservation, 105, 50, {
                    align: "center"
                });

                y = 60;

                // 📅 **Date de réservation et Client sur la même ligne**
                doc.setFontSize(12);
                doc.setFont("Times", "bold");
                const dateReservation = "Date de réservation : <?= date('d-m-Y H:i:s', strtotime($reservation['creer_le'])); ?>";
                const clientText = "Client Principal : <?= $clientName; ?>";

                // Position de la date (gauche)
                doc.text(dateReservation, 20, y);

                // Calcul de la position du client (droite)
                const textWidthClient = doc.getTextWidth(clientText);
                const xPositionClient = pageWidth - textWidthClient - 20;

                // Affichage du client à droite
                doc.text(clientText, xPositionClient, y);

                y += 20;

                let totalReservation = 0;
                let chambres = reservationElement.querySelectorAll(".chambre-block");

                chambres.forEach((chambre, index) => {
                    const chambreNumber = chambre.querySelector("h5").textContent.replace('Chambre N° ', '');
                    const accompagnateursList = chambre.querySelector("p").textContent.replace('Accompagnateurs :', '').trim();

                    doc.setFontSize(12);
                    doc.text("Chambre N° " + chambreNumber, 20, y);
                    doc.text("Accompagnateurs : " + accompagnateursList, 100, y);
                    y += 4;

                    let chambreTable = chambre.querySelector(".table-bordered");
                    if (chambreTable) {
                        doc.autoTable({
                            html: chambreTable,
                            startY: y,
                            theme: 'grid',
                            headStyles: {
                                halign: 'center',
                                fillColor: [22, 160, 133]
                            },
                            bodyStyles: {
                                halign: 'center'
                            }
                        });
                        y = doc.lastAutoTable.finalY + 10;
                    }

                    let commandesChambreTable = chambre.querySelector(".table-striped");
                    let totalChambre = 0;

                    if (commandesChambreTable) {
                        doc.setFontSize(12);
                        doc.text("Commandes pour cette chambre :", 20, y);
                        y += 2;

                        doc.autoTable({
                            html: commandesChambreTable,
                            startY: y,
                            theme: 'grid',
                            headStyles: {
                                halign: 'center',
                                fillColor: [52, 73, 94]
                            },
                            bodyStyles: {
                                halign: 'center'
                            }
                        });
                        y = doc.lastAutoTable.finalY + 10;

                        commandesChambreTable.querySelectorAll("tr").forEach((commandeRow) => {
                            let commandeMontant = commandeRow.querySelector("td.montant");
                            if (commandeMontant) {
                                totalChambre += parseFloat(commandeMontant.textContent.trim().replace(' FCFA', '').replace(/\s/g, ''));
                            }
                        });
                    }

                    let totalChambreElement = chambre.querySelector(".total-chambre");
                    if (totalChambreElement) {
                        totalChambre += parseFloat(totalChambreElement.textContent.trim().replace(' FCFA', '').replace(/\s/g, ''));
                    }

                    totalReservation += totalChambre;

                    // doc.setFontSize(12);
                    // doc.text("Montant Total Chambre " + chambreNumber + " : " + totalChambre.toLocaleString() + " FCFA", 20, y);
                    // y += 10;
                });

                // 🔹 **Montant Total (Chambre + Commande)**
                // const montantTotalChambreCommande = totalReservation.toLocaleString();
                // doc.setFontSize(14);
                // const totalText = "Montant Total (Chambre + Commande) : " + montantTotalChambreCommande + " FCFA";
                // const textWidth = doc.getTextWidth(totalText);
                // doc.text(totalText, pageWidth - textWidth - 20, y);
                // y += 10;

                // 💰 **Net à payer**
                doc.setFontSize(14);
                doc.setFont("times", "bold"); // Police en gras
                const totalGeneral = "<?= number_format($totalGeneral, 0, ',', ' '); ?>"; // Valeur formatée comme une chaîne
                const totalGeneralText = "Net à Payer : " + totalGeneral + " FCFA";
                const textWidthTotalGeneral = doc.getTextWidth(totalGeneralText);
                const xPositionTotalGeneral = pageWidth - textWidthTotalGeneral - 20;
                doc.text(totalGeneralText, xPositionTotalGeneral, y);
                y += 10;

                // 🔤 **Montant en lettres** (MAJUSCULE, GRAS, ITALIQUE)
                const totalEnLettres = convertNumberToWords(parseInt(totalGeneral.replace(/\s/g, ''))).toUpperCase() + " FCFA"; // Corrigé ici pour utiliser totalGeneral

                // Configuration du style de police
                doc.setFontSize(12);
                doc.setFont("times", "bolditalic"); // Gras + Italique

                // Calcul de la largeur du texte
                const totalEnLettresWidth = doc.getTextWidth(totalEnLettres);

                // Vérifier si le texte dépasse la largeur de la page
                const largeurPage = doc.internal.pageSize.width; // Largeur de la page
                let yPosition = y; // Position Y initiale pour l'affichage

                if (totalEnLettresWidth > largeurPage - 40) {
                    // Si le texte est trop long, on le coupe et met un retour à la ligne
                    const words = totalEnLettres.split(' ');
                    let line = "";

                    words.forEach((word) => {
                        const lineWidth = doc.getTextWidth(line + word + " ");
                        if (lineWidth > largeurPage - 40) {
                            doc.text(line, 100, yPosition); // Afficher la ligne et déplacer la position Y
                            yPosition += 10; // Incrémenter la position Y pour la ligne suivante
                            line = word + " "; // Réinitialiser la ligne avec le mot courant
                        } else {
                            line += word + " "; // Ajouter le mot à la ligne courante
                        }
                    });

                    // Afficher la dernière ligne
                    doc.text(line, 20, yPosition);
                    yPosition += 10; // Incrémenter la position Y pour la prochaine ligne
                } else {
                    // Si le texte ne dépasse pas, on l'affiche normalement
                    doc.text("Arrêter la présente facture au prix de " + totalEnLettres, 20, yPosition);
                    yPosition += 10; // Incrémenter la position Y après l'affichage
                }

                // Mettre à jour la position Y pour les éléments suivants
                y = yPosition;


                // 📂 **Conclusion**
                doc.text("Merci pour votre confiance. Nous vous souhaitons un agréable séjour.", 20, y);
                y += 20;

                // ✅ Ajout de la date et signature (aligné à droite)
                let date = new Date().toLocaleDateString("fr-FR"); // Obtenir la date formatée en français
                let location = "Fait à Cotonou, "; // Texte de la localisation (Fait à Cotonou)
                let signature = "Signature :"; // Texte de la signature, à ajuster selon ton besoin

                // Calcul de la largeur du texte combiné "Fait à Cotonou, " + date
                const textWidthLocationAndDate = doc.getTextWidth(location + date); // Largeur de "Fait à Cotonou" + date

                // Position X pour la date et la localisation (aligné à droite)
                const xPositionLocationAndDate = pageWidth - textWidthLocationAndDate - 20; // Aligné à droite

                // Affichage du texte "Fait à Cotonou, " + date
                doc.setFontSize(12); // Taille de la police pour "Fait à Cotonou" et la date
                doc.setFont("times", "bold"); // Police en gras
                doc.text(location + date, xPositionLocationAndDate, y); // Ajouter à la position calculée
                y += 10; // Incrémenter la position Y

                // Calcul de la largeur du texte de la signature
                // const textWidthSignature = doc.getTextWidth(signature); // Largeur de la signature

                // Position X pour la signature (aligné à droite)
                // const xPositionSignature = pageWidth - textWidthSignature - 20; // Aligné à droite

                // Affichage de la signature
                // doc.setFontSize(12); // Taille de la police pour la signature
                // doc.setFont("times", "normal"); // Police normale pour la signature
                // doc.text(signature, xPositionSignature, y); // Ajouter la signature à la position calculée
                // y += 10; // Incrémenter la position Y pour un espacement supplémentaire


                // 🖨️ **Télécharger le PDF**
                doc.save("Facture_" + numReservation + ".pdf");
            });
        });
    });
</script>


<!-- <script src="<?= PATH_PROJECT ?>public/vendor/html2canvas-1.4.1/html2canvas.min.js"></script> -->

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".generate-pdf").forEach(button => {
            button.addEventListener("click", function() {
                const reservationId = this.getAttribute("data-reservation");
                const element = document.getElementById("collapse" + reservationId);

                // Masquer les boutons avant la capture
                document.querySelectorAll(".generate-pdf").forEach(btn => btn.style.display = "none");

                html2canvas(element, {
                    scale: 2
                }).then(canvas => {
                    const imgData = canvas.toDataURL("image/png");
                    const pdf = new jspdf.jsPDF("p", "mm", "a4");

                    // ✅ Entête de la facture
                    pdf.setFontSize(18);
                    pdf.text("HÔTEL SOUS LES COCOTIERS", 105, 15, {
                        align: "center"
                    });

                    const logo = "<?= PATH_PROJECT ?>public/images/al_copyrighter.png"; // Remplace par l'URL du logo de l'hôtel
                    pdf.addImage(logo, "PNG", 10, 5, 30, 25);

                    pdf.setFontSize(12);
                    pdf.text("Adresse : A108 Adam Street NY 535022, BENIN", 105, 22, {
                        align: "center"
                    });
                    pdf.text("Téléphone : +229 62929439", 105, 28, {
                        align: "center"
                    });
                    pdf.text("Email : slescocotiers@gmail.com", 105, 34, {
                        align: "center"
                    });

                    // ✅ Numéro de réservation
                    pdf.setFontSize(16);
                    pdf.text("FACTURE DE RÉSERVATION N° " + reservationId, 105, 50, {
                        align: "center"
                    });

                    // ✅ Ajout du contenu de la réservation
                    const imgWidth = 190; // Augmenté de 10 pour plus de visibilité
                    const imgHeight = (canvas.height * imgWidth) / canvas.width; // Maintien des proportions
                    let position = 60; // Pour placer sous l'entête

                    pdf.addImage(imgData, "PNG", 15, position, imgWidth, imgHeight);

                    // ✅ Récupérer le montant du net à payer dans le DOM HTML
                    const montantElement = document.querySelector(`#montantTotal`); // Sélectionne l'élément avec l'ID 'montantTotal'
                    if (montantElement) { // Vérifie que l'élément existe
                        const montantText = montantElement.textContent.trim(); // Récupère le texte
                        const montant = parseInt(montantText.replace(/[^\d]/g, '')); // Extraire le montant numérique

                        // ✅ Transcrire le montant en lettre (en majuscule)
                        const montantLettre = convertNumberToWords(montant).toUpperCase(); // Fonction pour convertir en lettres

                        // ✅ Montant en chiffres (séparateur de milliers avec un espace)
                        const montantChiffres = montant.toLocaleString("fr-FR").replace(/,/g, " "); // Remplacer les virgules par un espace

                        // ✅ Ajout du montant à payer
                        position += imgHeight + 10;

                        pdf.setFont("times", "italic"); // Police Times New Roman en italique pour commencer
                        pdf.setFontSize(12);
                        pdf.text("Arrêtée la présente facture au montant de :", 15, position);

                        position += 8;

                        // ✅ Montant en lettres
                        pdf.setFont("times", "bolditalic"); // Police Times en gras et italique
                        pdf.text(montantLettre, 15, position);

                        // ✅ Montant en chiffres sur la même ligne, avec séparateur de milliers en espace
                        pdf.text(" (" + montantChiffres + " F CFA)", 15 + pdf.getTextWidth(montantLettre + " "), position);

                        // ✅ Gestion du débordement de ligne (si le texte est trop long, il passe à la ligne suivante)
                        const lineWidth = 190; // Largeur maximale avant un retour à la ligne
                        const totalWidth = pdf.getTextWidth(montantLettre + " " + montantChiffres + " F CFA") + 15;

                        if (totalWidth > lineWidth) {
                            const lines = pdf.splitTextToSize("Arrêtée la présente facture au montant de :" + " " + montantLettre + " " + "(" + montantChiffres + " F CFA)", lineWidth);
                            pdf.text(lines, 15, position);
                        }

                    } else {
                        console.error("Élément avec l'ID 'montantTotal' non trouvé.");
                    }


                    // ✅ Ajout de la date et signature (aligné à droite)
                    let date = new Date().toLocaleDateString("fr-FR");
                    position += 15;
                    pdf.setFontSize(12);
                    pdf.text("Fait à Cotonou, le " + date, 195, position, {
                        align: "right"
                    });

                    // ✅ Sauvegarde du PDF
                    pdf.save("Facture_Reservation_" + reservationId + ".pdf");

                    // Réafficher les boutons après la capture
                    document.querySelectorAll(".generate-pdf").forEach(btn => btn.style.display = "block");
                });
            });
        });
    });

    // Fonction pour convertir un nombre en lettre (version améliorée)
    function convertNumberToWords(number) {
        const ones = [
            "", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf", "dix", "onze", "douze", "treize", "quatorze", "quinze", "seize",
            "dix-sept", "dix-huit", "dix-neuf"
        ];
        const tens = [
            "", "", "vingt", "trente", "quarante", "cinquante", "soixante", "soixante", "quatre-vingts", "quatre-vingt"
        ];

        const thousands = [
            "", "mille", "million", "milliard"
        ];

        if (number === 0) {
            return "zéro";
        }

        let words = "";
        let groupIndex = 0;

        // Divise le nombre en groupes de 3 chiffres
        while (number > 0) {
            const group = number % 1000;
            if (group > 0) {
                let groupWords = convertGroupToWords(group, ones, tens);
                if (groupIndex > 0) {
                    groupWords += " " + thousands[groupIndex];
                }
                words = groupWords + " " + words;
            }
            number = Math.floor(number / 1000);
            groupIndex++;
        }

        return words.trim();
    }

    function convertGroupToWords(group, ones, tens) {
        let words = "";
        const hundred = Math.floor(group / 100);
        const remainder = group % 100;

        if (hundred > 0) {
            if (hundred > 1) {
                words += ones[hundred] + " cent";
            } else {
                words += "cent";
            }
            if (remainder > 0) {
                words += " ";
            }
        }

        if (remainder > 0) {
            if (remainder < 20) {
                words += ones[remainder];
            } else {
                const ten = Math.floor(remainder / 10);
                const one = remainder % 10;

                words += tens[ten];
                if (one > 0) {
                    if (ten === 7 || ten === 9) {
                        words += "-" + ones[10 + one];
                    } else {
                        words += "-" + ones[one];
                    }
                }
            }
        }

        return words;
    }
</script> -->


</body>

</html>