</div><!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer" style="background: var(--light); background-clip: border-box; border-top: 1px solid #e3e6f0;">
    <div class="container my-auto" style="color: firebrick; font-weight: bold;">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; SOUS LES COCOTIERS 2023</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= PATH_PROJECT ?>public/jquery/jquery.js"></script>
<script src="<?= PATH_PROJECT ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= PATH_PROJECT ?>public/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= PATH_PROJECT ?>public/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= PATH_PROJECT ?>public/vendor/chart.js/Chart.min.js"></script>
<script src="<?= PATH_PROJECT ?>public/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?= PATH_PROJECT ?>public/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Page level custom scripts -->
<script src="<?= PATH_PROJECT ?>public/js/demo/chart-area-demo.js"></script>
<script src="<?= PATH_PROJECT ?>public/js/demo/chart-pie-demo.js"></script>
<script src="<?= PATH_PROJECT ?>public/js/demo/datatables-demo.js"></script>


<!-- Bootstrap core JavaScript-->
<script src="<?= PATH_PROJECT ?>public/outils/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= PATH_PROJECT ?>public/select2/js/select2.min.js"></script>

<!-- Inclure Select2 JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->

<!-- Initialiser Select2 -->



<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>


</body>

</html>