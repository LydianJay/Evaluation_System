<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

     <!-- Navbar -->
     <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3 justify-content-end">
            
            
            <a class="nav-link text-dark d-flex ml-auto" href="<?php echo site_url('logout') ?>">
                <div class="text-dark text-center d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">power_settings_new</i>
                </div>
                <span class="nav-link-text ms-1">Logout</span>
            </a>
        </div>
    </nav>




    <container class="fluid py-4">

        <div class="row pt-5">
            <div class="col-12">
                <p class="h3 text-center">TEACHING EFFECTIVENESS EVALUATION</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-2 ms-3">
                <p class="h4 text-end">Course:</p>                
            </div>
            <div class="col-3">

                <select name="courseField" id="courseID" class="form control select2 w-50">
                    <option value="">Temp</option>
                </select>
               
            </div>
            <div class="col-2">
                <p class="h4 text-end">Term:</p>
            </div>
            <div class="col-3">
                <select name="termField" id="termID" class="form control select2 w-50">
                    <option value="">Temp</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-2 ms-3">
                <p class="h4 text-end">Professor:</p>
                
            </div>
            <div class="col-3">

                <select name="courseField" id="" class="form control select2 w-50">
                    <option value="">Temp</option>
                </select>
               
            </div>
            <div class="col-2">
                <p class="h4 text-end">AY:</p>
            </div>
            <div class="col-3">
                <select name="" id="" class="form control select2 w-50">
                    <option value="">Temp</option>
                </select>
            </div>
        </div>
        

        <div class="row">
            <div class="col">
                <p class="h3 text-center mt-5">Student Evaluation</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <p class="h5 text-center my-2">Average Rating per Semester</p>
            </div>
        </div>




    </container>



</main>