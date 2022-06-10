
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleadmin.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- fontgoogle -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- bootstrap5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>CRUD TEST</title>
</head>

<body style="background-color:#ffff; overflow:auto; ">

    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bxs-hand'></i>
            <span class="logo_name">CRUD TEST</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="homemanager.php">
                    <i class='bx bx-home-heart'></i>
                    <span class="link_name">HOME</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="homemanager.php">HOME</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bxs-report'></i>
                        <span class="link_name">Report</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="#">**Report**</a></li>
       
                    <li><a href="documentmembers.php">Members</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-book-alt'></i>
                        <span class="link_name">constant</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">**constant**</a></li>
                    <li><a href="membersadd.php">Members</a></li>
                </ul>
            </li>          
        </ul>
    </div>

    <!-- sidebar -->

    <!-- tabledata -->
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
           
        </div>
        <div class="container-fluid  " id="crudApp">
            <div class=" home_content ">

                <div class="col-12" align="center">
                    <div class="col-md-4">
                        <h1 class="mt-3" Style="border: 1px solid #000; border-radius: 30px; background-color:#DDDDDD;">
                            Create Members  </h1>
                    </div>
                    <div class=" form-group mb-3 col-lg-8 mt-4  ">
                        <input type="search" class="form-control form-control-md " placeholder="Search Here"
                            v-model="filtering">
                    </div>
                    <div class="col-12 mb-3" align="right">
                        <input type="button" class="btn btn-success btn-xs  " data-bs-toggle="modal"
                            data-bs-target="#myModal" @click="openModal" value="Add Members">
                    </div>
                    <hr>
                    <div class="table-responsive col-lg-12">
                        <table class="table table-bordered  table-striped table-lg">
                            <tr>
                                <th>#</th>
                                <th>Employee No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Date_Add</th>
                                <th>Date_Edit</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(row,index) in filteredRows " :key="row.employeeno">
                                <td>{{index+1}}</td>
                                <td>{{row.employeeno}}</td>
                                <td>{{row.Firstname}}</td>
                                <td>{{row.Lastname}}</td>
                                <td>{{row.Age}}</td>
                                <td>{{row.Address}}</td>
                                <td>{{row.Time_Add}}</td>
                                <td>{{row.Time_Edit}}</td>
                                <td>
                                    <button type="button" name="edit" class="btn btn-primary btn-sm
                        edit" data-bs-toggle="modal" @click="fetchData(row.employeeno)"
                                        data-bs-target="#myModal">Edit</button>
                                    <button type="button" name="delete" class="btn btn-danger btn-sm
                        delete" data-bs-toggle="modal" @click="deleteData(row.employeeno)"
                                        data-bs-target="#myModal">Delete</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div v-if="myModal" class="modal fade" id="myModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ dynamicTitle }}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        @click="myModal=false"></button>
                                </div>
                                <div class="modal-body row g-3  ">
                                    <div class="col-md-4">
                                        <label for="Employee"><i class='bx bx-bookmark-plus'></i>Employee:</label><br>
                                        <input type="text" v-model="employee_number"
                                            class="form-control form-control-sm" placeholder="Employee.."
                                            style="border-radius: 30px;" maxlength="15">
                                      
                                    </div>
                                    <div class="col-md-4">
                                        <label for="First Name"><i class='bx bx-user-pin'></i>First Name:</label><br>
                                        <input type="text" v-model="first_name" class="form-control form-control-sm"
                                            placeholder="First Name.." style="border-radius: 30px;" maxlength="25">
                                      
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Last Name"><i class='bx bx-user-pin'></i>Last Name:</label><br>
                                        <input type="text" v-model="last_name" class="form-control form-control-sm"
                                            placeholder="Last Name.." style="border-radius: 30px;" maxlength="25">                                       
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Age"><i class='bx bx-at'></i>Age:</label><br>
                                        <input type="Age" v-model="age_add" class="form-control form-control-sm"
                                            placeholder="Age.." style="border-radius: 30px;" maxlength="30">
                                    </div>
                                    <br>
                                    <div class="col-md-8">
                                        <label for="Address"><i class='bx bx-building-house'></i>Address:</label><br>
                                        <input type="text" v-model="local_address" class="form-control form-control-sm"
                                            placeholder="Address.." style="border-radius: 30px;" maxlength="80"> 
                                    </div>                                 
                                    <div class="modal-footer">
                                        <input type="hidden" v-model="hiddenId">
                                        <input type="button" v-model="actionButton" @click="submitData"
                                            class="btn btn-success btn-xs">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/dropdown.js"></script>
    <script src="../js/adduser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>