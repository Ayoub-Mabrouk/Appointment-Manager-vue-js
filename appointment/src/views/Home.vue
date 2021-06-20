<template>
<TheNavigation />
  <div class="home">
    <h1>Hello {{fullname}}</h1>
    <h2>Your Reference is {{Reference}}</h2>
  </div>
</template>

<script>
import TheNavigation from '@/components/TheNavigation.vue';

export default {
  name: 'Home',
  components: {
    TheNavigation
    
  },
  data(){
    return {
      Reference:localStorage.getItem('p_reference'),
      fullname:localStorage.getItem('full_name')
    }
  }
}
</script>
