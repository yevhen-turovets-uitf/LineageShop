<template>
  <BNavbarNav class="ml-auto">
    <BNavItem to="/auth">Войти</BNavItem>
    <BNavItem to="/registration">Зарегестрироваться</BNavItem>
    <BNavItemDropdown right>
      <template #button-content>
        По русски
        <img width="18" height="18" alt="" src="@/assets/rus.svg" />
      </template>
      <BDropdownItem href="#">
        English
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
