<style type="text/css">

   body a:focus {
      box-shadow: none;
   }
   /* LOGIN PAGE */
   body.login #login h1 {
      clip: rect(0,0,0,0);
      border-width: 0;
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      white-space: nowrap;
      width: 1px;
   }
   body.login #login {
      margin: 0 1.56rem;
      display: flex;
      padding: 2.61rem 1.37rem;
      flex-direction: column;
      align-items: flex-start;
      border-radius: 1.125rem;
      background: var(--primary-blue-100, #F3FAFF);
      position: relative;
      z-index: 21;
      max-width: 768px;
/*      transform: translateY(25%);*/
      width: calc(100% - 3.12rem);
      position: relative;
      top: 128px;
      margin-top: -2rem;
   }
   @media (min-width: 641px) {
      body.login #login {
         max-width: 768px;
         margin: 0 auto;
         padding: 3.44rem;
         margin-top: -3.5rem;
      }
   }
   @media (min-width: 1025px) {
      body.login #login {
         margin: 0;
         border-radius: 0;
         width: 50%;
         padding: 11.22em 9.03em;
         max-width: unset;
         transform: unset;
         top: 0;
      }
      body.login #login::after {
         content: '';
         position: absolute;
         top: 0;
         right: 0;
         width: 100%;
         height: 100%;
         transform: translateX(100%);
         background-position: top right;
         background-size: cover;
         background-repeat: no-repeat;
         <?php

         if ($bgimg = get_fields('options')['ls_image']['sizes']['large']){
            ?>
            background-image: url('<?php if ($bgimg = get_fields('options')['ls_image']['sizes']['large']) { echo $bgimg; } ?>');
            <?php
         }

         ?>
      }
   }
   body.login #login h2 {
      color: var(--primary-blue-900, #193F5B);
      font-family: Inter;
      font-size: 1.74881rem;
      font-style: normal;
      font-weight: 600;
      line-height: normal;
      letter-spacing: -0.06119rem;
      margin-bottom: 0.55rem;
   }
   body.login #login h2 + p {
      color: var(--primary-blue-900, #193F5B);
      font-family: Inter;
      font-size: 0.87438rem;
      font-style: normal;
      font-weight: 400;
      line-height: 130%; /* 1.13669rem */
      margin-bottom: 1.96rem;
      width: 23ch;
   }

   @media (min-width: 641px) {
      body.login #login h2 + p {
         width: unset;
      }
   }
   @media (min-width: 1025px) {
      body.login #login h2 + p {
         margin-bottom: 4.06em;
      }
   }
   /*body.login #login::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100vw;
      height: 100%;
      z-index: -1;
   }*/
   @media (max-width: 640px) {
      body.login #login-wrapper {
         <?php if($bgimg = get_fields('options')['ls_image']['sizes']['large']) {
         //TODO hide before if no background image
         ?>
         background-image: url(<?php echo $bgimg; ?>);
         background-position: top right;
         <?php } ?>
      }
   }
   @media (min-width: 641px) {
      body.login #login-wrapper {
         background-image: url('<?php
         echo get_fields('options')['ls_image']['sizes']['large'];
         ?>');
         background-position: top right;
      }
   }
   @media (min-width: 1025px) {
      body.login #login-wrapper {
         background-image: unset;
         display: flex;
      }
   }
   body.login #login #loginform, body.login-action-register #registerform {
      margin-top: 0;
      padding: unset;
      background: unset;
      border: unset;
      box-shadow: unset;
      width: 100%;
   }
   body.login #login #loginform label {
      clip: rect(0,0,0,0);
      border-width: 0;
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      white-space: nowrap;
      width: 1px;
   }
   body.login #login #loginform input:not([type="submit"]), body.login-action-lostpassword #lostpasswordform input:not([type="submit"]), body.login-action-register #registerform input:not([type="submit"]) {
      display: flex;
      height: 2.45925rem;
      padding: 0.49188rem 1.36625rem;
      align-items: center;
      gap: 0.65581rem;
      align-self: stretch;
      border-radius: 2.78713rem;
      border: 1px solid var(--primary-blue-900, #193F5B);
      box-shadow: 0px 0.8744px 1.74879px 0px rgba(16, 24, 40, 0.05);
      background: unset;
      margin-right: 0;
      font-size: unset;
      color: black;
   }
   body.login #login #loginform input:not([type="submit"]):first-of-type, body.login-action-lostpassword #lostpasswordform input:not([type="submit"]):first-of-type, body.login-action-register #registerform input:not([type="submit"]):first-of-type {
      margin-bottom: 1rem;
   }
   body.login #login #loginform .password-input {
      margin-bottom: 2rem !important;
   }
   @media (min-width: 1025px) {
      body.login #login #loginform .password-input {
         margin-bottom: 4.06em !important;
      }
   }
   body.login #login #loginform .forgetmenot {
      display: none;
   }
   body.login #login #loginform input[type="submit"], body.login-action-lostpassword #lostpasswordform input[type="submit"], body.login-action-register #login #registerform input[type="submit"] {
      width: 100%;
      float: unset;
      display: flex;
      padding: 0.65581rem 1.85806rem;
      justify-content: center;
      align-items: center;
      border-radius: 2.67781rem;
      background: var(--primary-blue-900, #193F5B);
      height: 2.45925rem;
      color: var(--primary-blue-100, #F3FAFF);
      font-family: Inter;
      font-size: 0.98369rem;
      font-style: normal;
      font-weight: 500;
      line-height: 115%; /* 1.13125rem */
      letter-spacing: -0.01475rem;
   }
   body.login #login #loginform input:not([type="submit"])::placeholder, body.login-action-lostpassword #lostpasswordform input:not([type="submit"])::placeholder, body.login-action-register #registerform input:not([type="submit"])::placeholder {
      color: var(--primary-blue-900, #193F5B);
      font-family: Inter;
      font-size: 0.87438rem;
      font-style: normal;
      font-weight: 400;
      line-height: 1; /* 1.00556rem */
      letter-spacing: -0.01313rem;
   }
   body.login #login #loginform .wp-hide-pw {
      display: none;
   }
   body.login #login #nav, body.login #login #backtoblog {
      display: none;
   }
   body.login #login #tf-after-login {
      color: var(--primary-blue-900, #193F5B);
      font-family: Inter;
      font-size: 0.875rem;
      font-style: normal;
      font-weight: 400;
      line-height: 130%;
      text-decoration-line: none;
      margin-top: 1.5rem;
   }
   body.login #login #tf-after-login a {
      text-decoration-line: underline;
      color: var(--primary-blue-900, #193f5b);
   }
   body.login #login #tf-after-login a:last-of-type {
      margin-top:6px;
      display: block;
   }
   @media (min-width: 1025px) {
      body.login #login #tf-after-login a:last-of-type {
         margin-top: 12px;
      }
   }
   #login-wrapper {
/*      margin-top: -2rem;*/
   }
   @media (min-width: 641px) {
      #login-wrapper {
/*         margin-top: -3.5625rem;*/
      }
   }
   @media (min-width: 1025px) {
      #login-wrapper {
         margin-top: unset;
      }
   }








   /* LOST PASSWORD PAGE */
   body.login-action-lostpassword #login-wrapper {
/*      margin-top: -1rem;*/
   }
   @media (min-width: 641px) {
      body.login-action-lostpassword #login-wrapper {
/*         margin-top: -2.3rem;*/
      }
   }
   body.login-action-lostpassword p.message {
      display: none;
   }
   body.login-action-lostpassword #lostpasswordform {
      background: unset;
      border: unset;
      box-shadow: unset;
      margin-top: 0;
      padding: unset;
   }
   body.login-action-lostpassword label {
      clip: rect(0,0,0,0);
      border-width: 0;
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      white-space: nowrap;
      width: 1px;
   }
   body.login-action-lostpassword #lostpasswordform input:not([type="submit"]):first-of-type {
      margin-bottom: 1.06rem;
   }
   body.login-action-lostpassword #lostpasswordform input[type="submit"] {
      width: 100%;
      /*width: 12.6875rem;*/
   }

   body.login-action-lostpassword #lostpasswordform h2 + p {
      width: unset;
      margin-bottom: 1.06rem;
   }

   @media (min-width: 1025px) {
      body.login-action-lostpassword #lostpasswordform h2 + p {
         margin-bottom: 2.38rem;
      }
      body.login-action-lostpassword #lostpasswordform input:not([type="submit"]):first-of-type {
         margin-bottom: 2.38rem;
      } 
      body.login-action-lostpassword label {
         clip: unset;
          border-width: unset;
          height: unset;
          margin: unset;
          overflow: unset;
          padding: unset;
          position: unset;
          white-space: unset;
          width: unset;
          border: none;
          color: var(--primary-blue-900, #193F5B);
         font-family: Inter;
         font-size: 0.875rem;
         font-style: normal;
         font-weight: 400;
         line-height: 130%; /* 1.1375rem */
      }
   }




   /* Lost password success page */
   body.login-action-checkemail #login-wrapper {
/*      margin-top: -1rem;*/
   }
   body.login-action-checkemail #login {
      background-color: var(--primary-blue-900, #193F5B);
      border-radius: 0.625rem;
   }
   body.login-action-checkemail #login h2, body.login-action-checkemail #login h2 + p {
      color: var(--primary-blue-300, #ceeaff);
   }
   body.login-action-checkemail #login h2 + p {
      width: unset;
/*      margin-bottom: 0;*/
   }
   body.login-action-checkemail #login h2 + p a {
      text-decoration: underline;
      color: var(--primary-blue-300, #ceeaff);
   }
   body.login-action-checkemail p.message {
      display: none;
   }
   body.login-action-checkemail #login .btn-light-blue-blue {
      width: 100%;
   }

   @media (min-width: 641px) {
      body.login-action-checkemail #login .btn-light-blue-blue {
         width: auto;
      }
   }

   @media (min-width: 1025px) {
      body.login-action-checkemail #login {
         border-radius: 0;
      }
   }




   /* Register page */
   body.login-action-register p.register {
      display: none;
   }
   body.login-action-register #login #registerform label {
      display: none;
   }
   body.login-action-register #login #registerform {
      display: flex;
      flex-direction: column;
   }
   @media (min-width: 1025px) {
      body.login-action-register #login #registerform label {
         display: block;
      }
      body.login-action-register #login #registerform {
         width: 100%;
      }
      body.login-action-register #login #registerform #first_last_name {
         width: 100%;
         display: flex;
         column-gap: 1.88rem;
      }
      body.login-action-register #login #registerform #first_last_name p {
         flex-basis: 50%;
      }
      body.login-action-register #login #registerform #wp-submit {
         width: auto;
      }
   }


   /**
    **********************************************
    ** BUTTONS 
    **********************************************
    */
   #wp-submit {
      transition: ease .2s;
   }
   #wp-submit:focus {
      outline: none;
      box-shadow: none;
   }
   @media (hover: hover) {
   #wp-submit:hover {
         background-color: var(--primary-blue-600) !important;
         color: var(--primary-blue-900) !important;
         border: solid 1px var(--primary-blue-600);
      }
	}



   body #login .btn-light-blue-blue {
      background-color: var(--primary-blue-300);
      display: flex;
      padding: 0.75rem 2.125rem;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      border-radius: 3.0625rem;
      color: var(--primary-blue-900, #193F5B);
      font-family: Inter;
      font-size: 1.125rem;
      font-style: normal;
      font-weight: 500;
      line-height: 115%; /* 1.29375rem */
      letter-spacing: -0.01688rem;
      transition: ease 0.2s;
   }
   @media (hover: hover) {
      body #login .btn-light-blue-blue:hover {
         color: var(--primary-blue-900);
         background-color: var(--primary-blue-600);
      }
   }


   /* Footer padding on login pages */
   @media (max-width: 1024px) {
      body .site-footer .footer-row-1 {
         padding-top: 175px;
      }
   }
  </style>
