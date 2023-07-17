<template>
    <div>
        <permission-tree-view
            v-for="(child, key) in nodes"
            :key="key"
            :node="child"
            :spacing="0"
            :selectedParentValues.sync="currentPermissions"
            @itemSelectedData="getSelectedItem($event)"
        />
    </div>
</template>

<script>
import { computed, ref } from '@vue/composition-api'
import PermissionTreeView from '@core/components/tree-view/PermissionTreeView.vue'
import { permissionList, removePermissionFromArray } from '@core/utils/permissions'

export default {
    name: 'userPermissions',
    components: { PermissionTreeView },
    props: {
        permissions: {
            type: Array,
            required: true
        },
        newPermissions: {
            type: Array,
            required: true
        }
    },
    setup(props) {
        const currentPermissions = computed(() => props.permissions)
        const newPermissions = ref(props.newPermissions)

        let tree = permissionList()
        let permissions = [];

        /* tree.forEach((permission) => {
            permissions.push(permission.text)
            if (permission.isParent == true) {
                permission.children.forEach((permission1) => {
                    permissions.push(permission1.text)
                })
            }
        })
        console.log(permissions) */

        const getSelectedItem = (event) => {
            //if (event.checkBoxEvent.event) {
                let allSelectedCheckBox = document.querySelectorAll('input[type=checkbox]:checked'), checkNewPermission = ref([])
                allSelectedCheckBox.forEach((item) => {
                    //newPermissions.value.push(item.dataset.value)
                    checkNewPermission.value.push(item.dataset.value)
                })
            newPermissions.value = checkNewPermission.value
            //}
        }

        setTimeout(() => {
            let permissions = currentPermissions.value
            if (permissions.length > 0) {
                permissions.forEach((permission) => {
                    document.getElementById(permission.name)
                        .setAttribute('checked', 'checked')
                })
            }
        }, 1000)

        return {
            currentPermissions,
            nodes: tree,
            getSelectedItem
        }
    }
}
</script>

<style scoped>

</style>
