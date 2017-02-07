    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <hr class="small">
                    <h4><strong>Discipleship Web Designs</strong>
                    </h4>
                    <p>P.O. Box 103, Bryson, Tx 76427</p>
                    <ul class="list-unstyled">
                        <li ><a href="tel:+9402575802" class="btn btn-success"><i class="fa fa-phone fa-fw"></i>940-257-5802</a></li>
                        <li> <a href="mailto:name@example.com"  class="btn btn-info"><i class="fa fa-envelope-o fa-fw"></i>info@discipleshipwebdesigns.com</a>
                        </li>
                    </ul>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                        </li>
                        
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; 2015 <a href="#">Discipleship Web Designs</a></p>
        </div>
    </footer>

    <!-- jQuery -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
        <!-- Script to Activate the Carousel -->

   

</body>
<?php 
    if(isset($db)){
        mysqli_close($db);
    };
 ?>
</html>