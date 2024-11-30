<a href="#"

   class="nav-item nav-link user-chat"
   data-user-id="<?= $_row["Cus_ID"] ?>"
   data-user-full-name="<?= $_row["Full_Name"] ?>"
   style="position: relative; margin-top: 1rem;">
    <span id="has_mess_user_id_<?= $_row["Cus_ID"] ?>" style="transform: translate(-2rem, .5rem) !important;" class="visually-hidden position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
  </span>
    <div class="d-inline-block" style="color:black"><?= $_row["Full_Name"] ?></div>
</a>