  <template>
  <TheNavigation />
  <div class="reservecontainer">
      <p>{{this.$route.params.a_id}}</p>
    <label for="date">Select a Date:</label>
    <input type="date" v-model="this.date"/>
  </div>
  <div v-if="toreserve" class="results">
    <div
      :class="[item == 'false' ? 'moraba3' : 'moraba32']"
      v-for="(item, key) in toreserve"
      :key="key">
      <div>
        <h6>{{ key }}</h6>
        <div v-if="item == 'false'">
          <button @click="edit(this.date+' '+key.slice(0, 2)+':00:00')">reserve now</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TheNavigation from '@/components/TheNavigation.vue';

export default {
  name: "Reserve",
  components: {
    TheNavigation
  },
  data() {
    return {
      date: this.$route.params.a_date.slice(0,-9),
      toreserve: undefined,
    };
  },
  methods: {
    async edit(date){
      console.log(date)
      let token = localStorage.getItem("token");
      const res = await fetch(
        "https://localhost/appointment-manager/app/appointment/edit_appointment",
        {
          method: "POST",
          headers: {
            "authorization": "Bearer " + token,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            a_id:this.$route.params.a_id,
            a_date: date
          }),
        }
      );
      console.log(res);
      if (res.status == 200) {
        let result = await res.json();
        if (!!result) {
          this.toreserve= undefined
        }else {
          localStorage.clear();
     this.$router.push('SignIn')
        }
      }
    },
    async SearchbyDay() {
      let token = localStorage.getItem("token");
      const res = await fetch(
        "https://localhost/appointment-manager/app/appointment/searchbyday",
        {
          method: "POST",
          headers: {
            "authorization": "Bearer " + token,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            a_date: this.date,
          }),
        }
      );
      this.toreserve = [];
      if (res.status == 200) {
        let result = await res.json();
        if (result!="false") {
          this.toreserve = result;
        }else {
          localStorage.clear();
     this.$router.push('SignIn')
        }
      }
    },
  },
  mounted(){
      this.SearchbyDay();
  },
  watch: {
    date() {
      this.SearchbyDay();
    },
  },
};
</script>

<style lang='scss'>
.results {
  display: flex;
  justify-content: space-evenly;
  .moraba3 {
    min-width: 120px;
    min-height: 160px;
    text-align: center;
    background: rgb(52, 155, 48);
    border: 2px solid rgb(0, 0, 54);
    border-radius: 8px;

    h6 {
      color: rgb(255, 255, 255);
      font-weight: 500;
      font-size: 25px;
      font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
        "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
    }
    p {
      color: black;
    }

  }
  .moraba32 {
    min-width: 120px;
    min-height: 160px;
    text-align: center;
    background: rgb(155, 48, 48);
    border: 2px solid rgb(0, 0, 54);
    border-radius: 8px;

    h6 {
      color: rgb(255, 255, 255);
      font-weight: 500;
      font-size: 25px;
      font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
        "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
    }
    p {
      color: black;
    }
   
  }
}
</style>

