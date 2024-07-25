<template>
  <div class="flex items-center">
    <svg v-if="field.isBusy" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path :class="field.isBusyByCurrentUser ? 'text-primary-500' : 'text-red-500'"
            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
            stroke-linecap="round"
            stroke-linejoin="round"/>
    </svg>
    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
         xmlns="http://www.w3.org/2000/svg">
      <path
          d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
          stroke-linecap="round" stroke-linejoin="round"
          style="color: #b5b5b5;"/>
    </svg>
    <span class="ml-2">{{ field.isBusy ? (field.isBusyByCurrentUser ? $t('Busy (You)') : $t('Busy')) : $t('Free') }}</span>
  </div>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>