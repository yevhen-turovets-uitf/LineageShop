<template>
  <BNavbarNav class="ml-auto">
    <BNavItem to="/auth">{{ $t('mainLayoutBlocks.login') }}</BNavItem>
    <BNavItem to="/registration">{{ $t('mainLayoutBlocks.register') }}</BNavItem>
    <BNavItemDropdown right>
      <template #button-content>
        {{ $t('mainLayoutBlocks.russian') }}
        <img width="18" height="18" alt="" src="@/assets/rus.svg" />
      </template>
      <BDropdownItem href="#">
        {{ $t('mainLayoutBlocks.english') }}
        <img width="18" height="18" alt="" src="@/assets/eng.svg" />
      </BDropdownItem>
    </BNavItemDropdown>
  </BNavbarNav>
</template>

<script>
export default {
  name: 'NotAuthorizedMenu'
};
</script>

<style scoped></style>
