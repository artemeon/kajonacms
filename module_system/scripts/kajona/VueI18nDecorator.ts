import { createDecorator } from 'vue-class-component'
import Lang from 'core/module_system/scripts/kajona/Lang'
export const FetchLang = (modules : Array<string>) => {
    return createDecorator((component, key) => {
        component.beforeRouteEnter = async (to, from, next) => {
            let en = {}
            let de = {}
            await Promise.all(modules.map(async module => {
                if (!window.i18n.messages.en[module]) {
                    en[module] = await Lang.fetchModule(module, 'en')
                    window.i18n.mergeLocaleMessage('en', en)
                }
                if (!window.i18n.messages.de[module]) {
                    de[module] = await Lang.fetchModule(module, 'de')
                    window.i18n.mergeLocaleMessage('de', de)
                }
            }))
            next()
        }
    })
}
