<template>
    <div>
        <b-row>
            <b-col md="12">
                <hr-dashboard
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <div class="app-calendar overflow-hidden border">
                    <div class="row no-gutters">
                        <!-- Calendar -->
                        <div class="col position-relative">
                            <div class="card shadow-none border-0 mb-0 rounded-0">
                                <div class="card-body pb-0">
                                    <full-calendar
                                        ref="refCalendar"
                                        :options="calendarOptions"
                                        class="full-calendar"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </b-col>
        </b-row>
    </div>
</template>
<script>
    import {
        BRow,
        BCol,
    } from 'bootstrap-vue'
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import VueContext from 'vue-context'

    // import useCalendar from "./useCalender";
    import hrDashboard from "./hrDashboard";
    export default {
        components: {
            FullCalendar, // make the <FullCalendar> tag available
            hrDashboard,
            BRow,
            BCol,
            VueContext
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin ],
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        start: 'prev,next, title',
                    },
                    dateClick: this.handleDateClick,
                    events: [
                        { title: 'event 1', date: '2019-04-01' },
                        { title: 'event 2', date: '2019-04-02' }
                    ]
                },
                menuData: [
                    { icon: 'PlusIcon', text: 'New' },
                    { icon: 'FileIcon', text: 'Open' },
                    { icon: 'SaveIcon', text: 'Save' },
                    { icon: 'SaveIcon', text: 'Save As' },
                    { icon: 'XIcon', text: 'Close' },
                ],
            }
        },
        methods: {
            handleDateClick: function(arg) {
                alert('date click! ' + arg.dateStr)
            }
        }
    }
</script>

<style lang="scss">
    @import "@core/scss/vue/apps/calendar.scss";
</style>
