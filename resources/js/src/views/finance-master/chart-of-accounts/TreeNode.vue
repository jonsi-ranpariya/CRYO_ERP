<template>
    <b-row :style="nodeMargin">
        <b-col cols="12">
            <b-alert
                show
                variant="primary"
            >
                <div class="alert-body">
                    <feather-icon
                        class="mr-25"
                        v-if="hasChildren"
                        :icon="toggleChildrenIcon"
                        @click="toggleChildren"
                        @keypress="toggleChildren"
                    />
                    <span class="ml-25">{{ node.label }}</span>
                    <b-button-group
                        size="sm"
                        class="float-right"
                    >
                        <b-button
                            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                            variant="outline-primary"
                            v-if="itLastLevel"
                            @click="openAddModel(node.d_id)"
                        >
                            Add
                        </b-button><!--v-b-modal.modal-primary-->
                        <b-button
                            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                            variant="outline-primary"
                            @click="openEditModel(node)"
                        >
                            Edit
                        </b-button>
                    </b-button-group>
                </div>
            </b-alert>

            <div v-if="hasChildren" v-show="showChildren">
                <TreeNode
                    v-for="child in node.children"
                    :key="child.id"
                    :node="child"
                    :spacing="spacing + 10"
                />
            </div>
            <div>
                <add-chart-of-account-modal :itemId="node.d_id"/>
                <edit-chart-of-account-modal :itemId="node.d_id" :itemData="node"/>
            </div>
        </b-col>
    </b-row>
</template>
<script>

    import {BAlert, BRow, BCol, BButton, BButtonGroup, BModal, VBModal} from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import AddChartOfAccountModal from "./addChartOfAccountModal";
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref, onUnmounted} from '@vue/composition-api'
    import EditChartOfAccountModal from "./editChartOfAccountModal";

    export default {
        name: 'TreeNode',
        components: {
            EditChartOfAccountModal,
            AddChartOfAccountModal,
            BAlert,
            BRow,
            BCol,
            BButton,
            BButtonGroup,
            BModal,
        },
        directives: {
            'b-modal': VBModal,
            Ripple,
        },
        props: {
            node: {
                type: Object,
                required: true
            },
            spacing: {
                type: Number,
                default: 0
            },
            itemData: Object
        },
        data() {
            return {
                showChildren: false,
            }
        },
        computed: {
            nodeMargin() {
                return {
                    'margin-left': `${this.spacing}px`
                }
            },
            hasChildren() {
                const {children} = this.node
                return children && children.length > 0
            },
            itLastLevel(){
                const { isLastLevel } = this.node
                return isLastLevel == 'No'
            },
            toggleChildrenIcon() {
                return this.showChildren ? 'MinusCircleIcon' : 'PlusCircleIcon'
            },
        },
        methods: {
            toggleChildren() {
                this.showChildren = !this.showChildren
            },
            openAddModel(id){
                this.$bvModal.show("modal-primary"+id)
            },
            openEditModel(data){
                this.$bvModal.show("edit-modal"+ data.d_id)
            }
        },
    }

</script>
