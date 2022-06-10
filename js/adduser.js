let app = new Vue({
    el: '#crudApp',
    data: {          
        allData: [],
        filtering: "",
        myModal: false,
        hiddenId: null,
        actionButton: 'Insert',
        dynamicTitle: 'Add Members'
    },
    methods: {
        fetchAllData() {   
            axios.post('../control/actionadd.php', {  
                actions: 'fetchall'                          
            }).then(res => {           
                app.allData = res.data;    
            })
        },
        openModal(){    //เปิด model
        app.employee_number='';
        app.first_name='';
        app.last_name='';
        app.age_add='';
        app.local_address='';
        app.actionButton='Insert';
        app.dynamicTitle ='Add Members';
        app.myModal = true; 
       },
       submitData:function(){
            if(app.employee_number == '' || app.first_name == '' || app.last_name == '' || app.age_add == '' || app.local_address == '' )
            {
                alert('กรุณากรอกข้อมูล พนักงานให้ครบ');
                window.location.reload();
            }
            else
            {
                if(app.actionButton == 'Insert'){  
                    axios.post('../control/actionadd.php',{  
                        actions: 'insert',   
                        employeeNumber: app.employee_number,  
                        firstName: app.first_name,
                        lastName: app.last_name,
                        ageAdd: app.age_add,
                        localAddress: app.local_address,
                    }).then(res => {             
                        app.myModal = false;
                        app.fetchAllData();  
                        app.employee_number='';
                        app.first_name='';
                        app.last_name='';
                        app.age_add='';
                        app.local_address='';
                        if(res.data.message) alert(res.data.message);   
                        else {alert('กรุณากรอกใหม่ ข้อมูลซ้ำ!');}
                        window.location.reload();
                    })
                }
                if(app.actionButton == 'Update'){  
                    axios.post('../control/actionadd.php',{   
                        actions: 'update',
                        employeeNumber: app.employee_number,  
                        firstName: app.first_name,
                        lastName: app.last_name,
                        ageAdd: app.age_add,
                        localAddress: app.local_address,
                        hiddenId: app.hiddenId
                    }).then(res => {               
                        console.log(app.department_ssp)
                        app.myModal = false;
                        app.fetchAllData();    
                        app.employee_number='';
                        app.first_name='';
                        app.last_name='';
                        app.age_add='';
                        app.local_address='';
                        app.hiddenId='';
                        if(res.data.message) alert(res.data.message);   
                        else {alert('กรุณากรอกใหม่ ข้อมูลซ้ำ!');}       
                        window.location.reload();
                    })
                }
            }
       },
       fetchData(id){ 
           axios.post('../control/actionadd.php',{   
               actions: 'fetchSingle',
               id: id  
           }).then(res => {   
               app.employee_number = res.data.employee_number; 
               app.first_name = res.data.first_name;
               app.last_name = res.data.last_name;
               app.age_add = res.data.age_add;
               app.local_address = res.data.local_address;
               app.hiddenId = res.data.id;
               app.myModal = true;
               app.actionButton = 'Update';
               app.dynamicTitle = 'Edit Members';
           })
       },
       deleteData(id){  
           if(confirm('Are you sure you want to delete')){
               axios.post('../control/actionadd.php',{ 
                   actions: 'delete',    
                   id: id  
               }).then(res => {   
                   app.fetchAllData(); 
                   
                   alert(res.data.message);
               });
           }
       },
    },
    created() {
        this.fetchAllData();        
    },
    computed: {
        filteredRows()
        {
        return this.allData.filter(row => 
            {   
            const employeeNumber = row.employeeno.toLowerCase();
            const firstName = row.Firstname.toLowerCase();
            const lastName = row.Lastname.toLowerCase();
            const ageAdd = row.Age.toLowerCase();
            const local_address = row.Address.toLowerCase();
            const time_add = row.Time_Add.toLowerCase();
            const time_edit = row.Time_Edit.toLowerCase();
            const searchTerm = this.filtering.toLowerCase();

        return (
            
            employeeNumber.includes(searchTerm) ||     
            firstName.includes(searchTerm) ||
            lastName.includes(searchTerm) ||
            ageAdd.includes(searchTerm) ||
            local_address.includes(searchTerm) || 
            time_add.includes(searchTerm) ||
            time_edit.includes(searchTerm) 
               );
            
            });
        }
    }
   
})