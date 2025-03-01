</div><!-- Fin du contenu principal -->

<!-- Pied de page -->
<footer class="sticky-footer shadow" style="background: #1a1814; background-clip: border-box; border-top: 1px solid #1a1814;">
    <div class="container">
        <div class="copyright text-center my-auto">
            &copy; Copyright <strong><span>Sous Les Cocotiers</span></strong>. Tout Droit Reservé
        </div> <br>
        <div class="copyright text-center my-auto">
            Designed by <a href="#">Franco Services</a>
        </div>
    </div>
</footer>
<!-- Fin du pied de page -->

</div>
<!-- Fin du conteneur de contenu -->

</div>
<!-- Bouton de retour en haut de page -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Modal de déconnexion -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session actuelle.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-primary" href="login.html">Déconnexion</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript de base Bootstrap -->
<script src="<?= PATH_PROJECT ?>public/outils/jquery/jquery.js"></script>
<script src="<?= PATH_PROJECT ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript principal -->
<script src="<?= PATH_PROJECT ?>public/outils/jquery-easing/jquery.easing.min.js"></script>

<!-- Scripts personnalisés pour toutes les pages -->
<script src="<?= PATH_PROJECT ?>public/js/sb-admin-2.min.js"></script>

<!-- Plugins de niveau page -->
<!-- <script src="<?= PATH_PROJECT ?>public/vendor/chart.js/Chart.min.js"></script> -->
<script src="<?= PATH_PROJECT ?>public/outils/datatables/jquery.dataTables.js"></script>
<script src="<?= PATH_PROJECT ?>public/outils/datatables/dataTables.bootstrap4.js"></script>

<!-- Scripts personnalisés de niveau page -->
<!-- <script src="<?= PATH_PROJECT ?>public/js/demo/chart-area-demo.js"></script>
<script src="<?= PATH_PROJECT ?>public/js/demo/chart-pie-demo.js"></script> -->
<script src="<?= PATH_PROJECT ?>public/js/demo/datatables-demo.js"></script>

<!-- JavaScript de base Bootstrap -->
<script src="<?= PATH_PROJECT ?>public/outils/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Inclure Select2 JS -->
<script src="<?= PATH_PROJECT ?>public/outils/select2/js/select2.min.js"></script>

<script>
    // Dans votre JavaScript (ressource .js externe ou balise <script>)
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>

</body>
</html>
