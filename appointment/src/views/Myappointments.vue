<template>
<TheNavigation />
  <div class="tablecontainer">
    <table>
      <caption>
        My Appointments
      </caption>
      <thead>
        <tr>
          <th>Date</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="app in appointments" :key="app.a_id">
          <td>{{ app.a_date }}</td>
          <td><button to="/reserve"><router-link :to="{ name: 'Edit' , params: {a_id: app.a_id, a_date : app.a_date } }">🖊 Edit</router-link></button></td>
          <td><button @click="delete_app(app.a_id)">🗑 Delete</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import TheNavigation from '@/components/TheNavigation.vue';

export default {
  name: "Myappintments",
  components:{
    TheNavigation
  },
    data() {
      return {
          appointments:undefined
      }
    },
  methods: {
      async delete_app(id) {
          console.log(id)
      let token = localStorage.getItem("token");
      const res = await fetch(
        "https://localhost/appointment-manager/app/appointment/cancel_appointment",
        {
          method: "POST",
          headers: {
            "authorization": "Bearer " + token,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            a_id: id,
          }),
        }
      );
      if (res.status == 200) {
        let result = await res.json();
        if (result!="false") {
          this.getAppointments();
        }else  {
          localStorage.clear();
     this.$router.push('SignIn')
        }
      }
    },
    async getAppointments() {
        let token = localStorage.getItem('token');
        const res = await fetch("http://localhost/appointment-manager/app/appointment/myappointments",
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
            this.appointments=result;
            console.log(result)
          }else {
            localStorage.clear();
     this.$router.push('SignIn')
          }
        }
    },
  },
  beforeMount() {
    this.getAppointments();
  },
};
</script>

<style scoped>


.tablecontainer {
  display: flex;
  justify-content: center;
}
table {
  font-family: "Helvetica Neue", Helvetica, sans-serif;
  width: 40%;
}

caption {
  text-align: left;
  color: silver;
  font-weight: bold;
  text-transform: uppercase;
  padding: 5px;
}

thead {
  background: rgb(135, 162, 184);
  color: white;
}

th,
td {
  padding: 5px 8px;
  
}

tbody tr td:nth-child(1) {
  text-align: center;
}
tbody tr td button a {
  color: rgb(0, 0, 0);
}

tbody tr td:nth-child(2),
tbody tr td:nth-child(3) {
  
  text-align: right;
  font-family: monospace;
}
</style>