import Vue from 'vue'
import Router from 'vue-router'
import Reportgenerator from 'core_agp/module_reportconfigurator/scripts/components/Reportgenerator/Reportgenerator.vue'
Vue.use(<any>Router)

export default new Router({
    routes: [
        { path: '/reportconfigurator/test',
            component: Reportgenerator
        }
    ]
})
