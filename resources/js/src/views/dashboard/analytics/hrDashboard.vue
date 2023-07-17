<template>
    <section id="card-text-alignment">
        <b-row>
            <b-col
                md="6"
                lg="4"
            >
                <b-card
                    class="mb-3"
                >
                    <b-row>
                        <b-col md="12" class="d-flex">
                            <b-avatar
                                class="mb-1"
                                :variant="`light-primary`"
                                size="40"
                            >
                                <feather-icon
                                    color="primary"
                                    icon="HelpCircleIcon"
                                    size="20"
                                    class="d-flex"
                                />
                            </b-avatar>
                            &nbsp;&nbsp;
                            <h5 class="d-flex mr-4 mt-1">Thought For The Day</h5>
                        </b-col>
                    </b-row>
                    <b-card-text>
                        " The sooner we come to understand that things can be done without our assistance, he sooner we
                        reach our philosophyf life. "
                    </b-card-text>
                </b-card>
            </b-col>
            <b-col
                md="6"
                lg="4"
            >
                <b-card
                    class="mb-3"
                >
                    <b-row>
                        <b-col md="12" class="d-flex">
                            <b-avatar
                                class="mb-1"
                                :variant="`light-primary`"
                                size="40"
                            >
                                <feather-icon
                                    color="primary"
                                    icon="GiftIcon"
                                    size="20"
                                    class="d-flex"
                                />
                            </b-avatar>
                            &nbsp;&nbsp;
                            <h5 class="d-flex mr-4 mt-1">Birthday</h5>
                        </b-col>
                    </b-row>
                    <b-card-text class="mt-2">
                        No One's Birthday Today
                    </b-card-text>
                    <br>
                </b-card>
            </b-col>
            <b-col
                md="6"
                lg="4"
            >
                <b-card
                    class="mb-3"
                >
                    <b-row>
                        <b-col md="12" class="d-flex">
                            <b-avatar
                                class="mb-1"
                                :variant="`light-primary`"
                                size="40"
                            >
                                <feather-icon
                                    color="primary"
                                    icon="CalendarIcon"
                                    size="20"
                                    class="d-flex"
                                />
                            </b-avatar>
                            &nbsp;&nbsp;
                            <h5 class="d-flex mr-4 mt-1">Work Anniversary</h5>
                        </b-col>
                    </b-row>
                    <b-card-text class="mt-2">
                        No Work Anniversary Today.
                    </b-card-text>
                    <br>
                </b-card>
            </b-col>
        </b-row>
    </section>
</template>
<script>
    import {
        BRow,
        BCol,
        BCard,
        BCardText,
        BButton,
        BAvatar
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardText,
            BButton,
            BAvatar,
        },
        directives: {
            Ripple,
        },
    }
</script>
