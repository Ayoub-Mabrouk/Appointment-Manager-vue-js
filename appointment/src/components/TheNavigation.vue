<template>
  <div class="topnav" >
    
      <router-link :to="{ name: 'Home' }">Home</router-link>
       <router-link :to="{ name: 'Reserve' }">Reserve</router-link>
       <router-link :to="{ name: 'Myappointments' }">My Appointments</router-link>
       <router-link :to="{ name: 'Logout' }">Logout</router-link>

  </div>
</template>
<script>
export default {
  data(){
    return {
      login:false,
      fullname:localStorage.getItem('full_name')
    }
  },
  methods:{
async check_expiration() {
        let token = localStorage.getItem('token');
        const res = await fetch("https://localhost/appointment-manager/app/patient/check_expiration",
          {
            method: "POST",
            headers: {
              "authorization": "Bearer " + token,
              "Content-Type": "application/json",
            },
          }
        );
        if (res.status == 200) {
          let result = await res.json();
          if (result!="false") {
            this.login=true;
          }else {
            this.login=false;
            localStorage.clear();
     this.$router.push('SignIn')
          }
        }
    },
  },
  beforeMount() {
    this.check_expiration();
  },
};
</script>
<style>
.topnav {
  background-color: #333;
  overflow: hidden;
  text-decoration: none;
}
.topnav ul li {
  list-style: none;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
  text-decoration: none;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #04aa6d;
  color: white;
  text-decoration: none;
}
</style>