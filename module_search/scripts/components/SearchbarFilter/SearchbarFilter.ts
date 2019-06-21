import { Component, Vue } from 'vue-property-decorator'
import { namespace } from 'vuex-class'
import Loader from 'core/module_system/scripts/components/Loader/Loader.vue'
import Multiselect from 'core/module_system/scripts/components/Multiselect/Multiselect.vue'
import { FilterModule, User } from '../../Interfaces/SearchInterfaces'
import Datepicker from 'core/module_system/scripts/components/Datepicker/Datepicker.vue'
import Autocomplete from 'core/module_system/scripts/components/Autocomplete/Autocomplete.vue'

@Component({ components: { Loader, Multiselect, Datepicker, Autocomplete } }) class SearchbarFilter extends Vue {
    @namespace('SearchModule').Action getFilterModules : any
    @namespace('SearchModule').Action setSelectedIds : any
    @namespace('SearchModule').Action triggerSearch : any
    @namespace('SearchModule').Action setStartDate: any
    @namespace('SearchModule').Action setEndDate: any
    @namespace('SearchModule').Action setSelectedUser : any
    @namespace('SearchModule').Action resetSelectedUser : any
    @namespace('SearchModule').Action getAutocompleteUsers : any
    @namespace('SearchModule').State filterModules : Array<FilterModule>
    @namespace('SearchModule').State searchQuery : string
    @namespace('SearchModule').State selectedIds : Array<string>
    @namespace('SearchModule').State autoCompleteUsers : Array<User>

    private filterIsOpen : boolean = false

    private toggleFilter () : void {
        if (this.filterModules === null) {
            this.getFilterModules()
        }
        this.filterIsOpen = !this.filterIsOpen
    }
    private get moduleNames () : Array<string> {
        return this.filterModules.map(element => element.module)
    }
    onModulesChange (filters : Array<string>) : void {
        let ids = []
        filters.map(selectedFilter => {
            this.filterModules.map(filter => {
                if (filter.module === selectedFilter) {
                    ids.push(filter.id.toString())
                }
            })
        })
        this.setSelectedIds(ids)
        if (this.searchQuery.length >= 2) {
            this.triggerSearch()
        }
    }
    private onStartDateChange (startDate : string) : void {
        this.setStartDate(startDate)
        if (this.searchQuery.length >= 2) {
            this.triggerSearch()
        }
    }
    private onEndDateChange (endDate : string) : void {
        this.setEndDate(endDate)
        if (this.searchQuery.length >= 2) {
            this.triggerSearch()
        }
    }
    private onUserSelect (user : User) : void {
        this.setSelectedUser(user.systemid)
        if (this.searchQuery.length >= 2) {
            this.triggerSearch()
        }
    }
    private onUserDelete () : void {
        this.resetSelectedUser()
        if (this.searchQuery.length >= 2) {
            this.triggerSearch()
        }
    }
    private async onAutocompleteInput (e : string) : Promise<void> {
        this.getAutocompleteUsers(e)
    }
}

export default SearchbarFilter
