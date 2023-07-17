<template>
    <b-row :style="nodeMargin">
        <b-col cols="12">
            <b-alert
                show
                variant="success"
            >
                <div class="alert-body">
                    <feather-icon
                        class="float-left"
                        style="margin-top: 5px;margin-right: 10px;"
                        v-if="hasChildren"
                        :icon="toggleChildrenIcon"
                        @click="toggleChildren"
                        @keypress="toggleChildren"
                    />
                    <b-form-group
                        size="sm"
                        class="float-left"
                    >
                        <input
                            type="checkbox"
                            v-if="node.isParent"
                            :id="node.text"
                            :data-value="node.text"
                            name="permission"
                            @input="selectCheckbox($event.target.checked, node)"
                            class="checkBoxDesign"
                        />
                        <input
                            v-else
                            :id="node.text"
                            :data-value="node.text"
                            name="permission"
                            type="checkbox"
                            @input="selectCheckbox($event.target.checked, node)"
                            class="checkBoxDesign"
                        />
                    </b-form-group>
                    <span class="ml-25 text-primary">{{ node.text }}</span>
                </div>
            </b-alert>

            <div v-if="hasChildren" v-show="showChildren">
                <PermissionTreeView
                    v-for="(child, key) in node.children"
                    :key="key"
                    :node="child"
                    :spacing="spacing + 10"
                    @itemSelectedData="$emit('itemSelectedData', {node: child, checkBoxEvent: $event})"
                    :selectedParentValues.sync="parentValues"
                />
            </div>
        </b-col>
    </b-row>
</template>

<script>
import { BAlert, BRow, BCol, BButton, BButtonGroup, BFormCheckbox, BFormInput, BFormGroup } from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { computed } from '@vue/composition-api'

export default {
    name: 'PermissionTreeView',
    components: {
        BAlert,
        BRow,
        BCol,
        BButton,
        BButtonGroup,
        BFormCheckbox,
        BFormInput,
        BFormGroup
    },
    directives: {
        Ripple,
    },
    computed: {
        nodeMargin() {
            return {
                'margin-left': `${this.spacing}px`
            }
        },
        hasChildren() {
            const { children } = this.node
            return children && children.length > 0
        },
        toggleChildrenIcon() {
            return this.showChildren ? 'MinusCircleIcon' : 'PlusCircleIcon'
        },
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
        selectedParentValues: {
            required: true
        }
    },
    data() {
        return {
            showChildren: false,
            parentValues: this.selectedParentValues
        }
    },
    methods: {
        toggleChildren() {
            this.showChildren = !this.showChildren
        },
    },
    setup(props, { emit }) {
        const currentNode = computed(() => props.node)

        const currenSelectedValues = computed(() => props.selectedParentValues)
        //console.log(currenSelectedValues.value)

        const currentItem = currentNode.value.text

        const selectCheckbox = async (event, node) => {
            if (event) {
                if (node.isParent) {
                    if(node.children.length > 0) {
                        await selectEveryChild(node)
                    }
                } else {
                    document.getElementById(node.text).setAttribute('checked', 'checked')
                }
            } else {
                if (node.isParent) {
                    if(node.children.length > 0) {
                        await removeEveryChild(node)
                    }
                } else {
                    document.getElementById(node.text).removeAttribute('checked')
                }
            }
            emit('itemSelectedData', {node: node, event: event})
        }

        const selectEveryChild = async (node) => {
            await node.children.forEach((item) => {
                document.getElementById(item.text).setAttribute('checked', 'checked')
                if (item.isParent) {
                    if (item.children.length > 0) {
                        selectEveryChild(item)
                    }
                }
            })
        }

        const removeEveryChild = async (node) => {
            await node.children.forEach((item) => {
                document.getElementById(item.text).removeAttribute('checked')
                if (item.isParent) {
                    if (item.children.length > 0) {
                        removeEveryChild(item)
                    }
                }
            })
        }

        return {
            selectCheckbox,
            currentNode,
            currentItem
        }
    }
}
</script>

<style>
.checkBoxDesign {
    height: 15px;
    width: 15px;
    margin-top: 2px;
    margin-right: 5px;
}
.checkBoxDesign:hover {
    height: 17px;
    width: 17px;
    margin-top: 2px;
    margin-right: 5px;
}
</style>
