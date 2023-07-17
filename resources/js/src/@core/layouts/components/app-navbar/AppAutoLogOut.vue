<template>
<!--    <div class="mr-25 mt-1 logoutDesign">
        <p>{{ dateTime }}</p>
    </div>-->
</template>

<script>
// Auto Logout User
import { clearLocalStorageData, logoutUser } from '@core/utils/utils'
import { ref } from '@vue/composition-api'

export default {
    name: 'AppAutoLogOut',
    setup() {
        const timeoutInMs = 1800000
        let timeoutId;
        const dateTime = ref(null)

        const startTimer = () => {
            timeoutId = setTimeout(handleInactive, timeoutInMs);
            setInterval(() => {
                dateTime.value = timeoutId
            },1000)
        }

        const handleInactive = async () => {
            await logoutUser().then((res) => {
                if (res.status === 200){
                    clearLocalStorageData()
                }
            }).catch(() => {
                clearLocalStorageData()
            })
        }

        const resetTimer = () => {
            clearTimeout(timeoutId);
            startTimer();
        }

        const setupTimers = () => {
            document.addEventListener("keypress", resetTimer, false);
            document.addEventListener("mousemove", resetTimer, false);
            document.addEventListener("mousedown", resetTimer, false);
            document.addEventListener("touchmove", resetTimer, false);
            document.addEventListener("load", resetTimer, false);
            document.addEventListener("scroll", resetTimer, false);
            //document.addEventListener("visibilitychange", handleInactive, false);

            startTimer();
        }
        setupTimers();

        return {
            timeoutInMs,
            timeoutId,
            setupTimers,
            startTimer,
            handleInactive,
            resetTimer,
            dateTime
        }
    }
}
</script>

<style scoped>
.logoutDesign p{
    border: transparent;
    color: red;
    font-weight: bold;
}
</style>
