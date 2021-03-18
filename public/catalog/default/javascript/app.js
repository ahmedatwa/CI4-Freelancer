
const tabs = [
  {
    name: 'Home',
    component: {
      template: `<div class="tab-pane">Home component</div>`
    }
  },
  {
    name: 'Posts',
    component: {
      template: `<div class="tab-pane">Posts component</div>`
    }
  },
  {
    name: 'Archive',
    component: {
      template: `<div class="tab-pane">Archive component</div>`
    }
  }
]


const freelancerApp = Vue.createApp({
  data() {
    return {
        url:'https://freelancer.localhost/', 
        tabs,
        currentTab: tabs[0]
    }
  },
  computed: {
    currentTabComponent() {
      return 'tab-' + this.currentTab.toLowerCase()
    }
  },
  methods: {
             getOpenProjects(){ axios.get(url + "employer/project/getOpenProjects").then(function(response){
              //console.log(response.data)
                 if(response.data.users == null){
                     //v.noResult()
                    }else{
                      freelancerApp.getData(response.data.users);
                    }
            })
        },

  }
})



freelancerApp.mount('#app')

