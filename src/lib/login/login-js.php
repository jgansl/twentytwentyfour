
   <script>
      document.addEventListener('DOMContentLoaded', function() {

         /* Login page */
         if (document.body.classList.contains('login-action-login')) {
           var container = document.createElement('div');
           container.id = 'login-wrapper';

           var elementToWrap = document.getElementById('login');
           elementToWrap.parentNode.insertBefore(container, elementToWrap);
           container.appendChild(elementToWrap);

            document.getElementById('user_login').setAttribute('placeholder', '<?php echo !empty($options['email_placeholder']) ? str_replace("'", "\'", $options['email_placeholder']) : 'Email'; ?>');
            document.getElementById('user_pass').setAttribute('placeholder', '<?php echo !empty($options['password_placeholder']) ? str_replace("'", "\'", $options['password_placeholder']) : 'Password'; ?>');
            document.getElementById('wp-submit').setAttribute(
               'value', 
               '<?php echo !empty($options['login_button_text']) ? str_replace("'", "\'", $options['login_button_text']) : 'Log In' ?>'
            );

            <?php

            if (!empty(get_field('after_login_html', 'options'))) {   
               ?>
               document.getElementById('loginform').innerHTML += '<?php echo str_replace("'", "\'", $options['after_login_html']); ?>';
               <?php
            }

            ?>
         }

         /* Lost password page */
         if (document.body.classList.contains('login-action-lostpassword')) {

            var container = document.createElement('div');
           container.id = 'login-wrapper';

           var elementToWrap = document.getElementById('login');
           elementToWrap.parentNode.insertBefore(container, elementToWrap);
           container.appendChild(elementToWrap);

             document.getElementById('user_login').setAttribute('placeholder', '<?php echo !empty($options['email_placeholder']) ? str_replace("'", "\'", $options['email_placeholder']) : 'Email'; ?>');

            <?php
            if (!empty($options['lp_subtitle'])) {
               ?>
               document.getElementById('lostpasswordform').innerHTML = '<p><?php echo str_replace("'", "\'", $options['lp_subtitle']); ?></p>' + document.getElementById('lostpasswordform').innerHTML;
               <?php
            }

            if (!empty($options['lp_title'])) {
               ?>
               document.getElementById('lostpasswordform').innerHTML = '<h2><?php echo str_replace("'", "\'", $options['lp_title']); ?></h2>' + document.getElementById('lostpasswordform').innerHTML;
               <?php
            }

            ?>

             document.getElementById('wp-submit').setAttribute('value', '<?php echo !empty($options['lp_button_text']) ? str_replace("'", "\'", $options['lp_button_text']) : 'Reset Password'; ?>');

             document.getElementsByTagName('label')[0].innerHTML = '<?php echo !empty($options['email_placeholder']) ? str_replace("'", "\'", $options['email_placeholder']) : 'Email'; ?>';
         }

         /* Lost password success page */
         if (document.body.classList.contains('login-action-checkemail')) {
            var container = document.createElement('div');
           container.id = 'login-wrapper';

           var elementToWrap = document.getElementById('login');
           elementToWrap.parentNode.insertBefore(container, elementToWrap);
           container.appendChild(elementToWrap);

           document.querySelector('#login h2').innerHTML = '<?php echo !empty($options['ss_title']) ? str_replace("'", "\'", $options['ss_title']) : 'You\'re all set!'; ?>';
           document.querySelector('#login h2 + p').innerHTML = '<?php echo !empty($options['ss_subtitle']) ? str_replace("'", "\'", $options['ss_subtitle']) : 'Check your email for a confirmation link and then visit the <a href="/wp-login.php">Login Page</a>.'; ?>';

           <?php

           if (!empty($options['ss_button']) && !empty($options['ss_button']['url']) && !empty($options['ss_button']['title'])) {
               ?>
                  document.getElementById('login').innerHTML = document.getElementById('login').innerHTML + '<?php echo '<a href="/wp-login.php" class="btn-light-blue-blue" href="' . $options['ss_button']['url'] . '" ' . (!empty($options['ss_button']['target']) ? 'target="blank"' : '') . '><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="mask0_323_3674" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="25" height="25"><rect x="24.5" y="24.5" width="24" height="24" transform="rotate(180 24.5 24.5)" fill="#D9D9D9"/></mask><g mask="url(#mask0_323_3674)"><path d="M10.5 6.5L11.9 7.95L8.35 11.5L20.5 11.5L20.5 13.5L8.35 13.5L11.9 17.05L10.5 18.5L4.5 12.5L10.5 6.5Z" fill="#193F5B"/></g></svg> ' . $options['ss_button']['title'] . '</a>'; ?>';
               <?php
           }

           ?>
         }

         if (document.body.classList.contains('login-action-register')) {

            var container = document.createElement('div');
           container.id = 'login-wrapper';

           var elementToWrap = document.getElementById('login');
           elementToWrap.parentNode.insertBefore(container, elementToWrap);
           container.appendChild(elementToWrap);

            if ($('#user_login')) {
               $('#user_login').attr('placeholder', '<?php echo !empty($options['username_placeholder']) ? str_replace("'", "\'", $options['username_placeholder']) : ''; ?>');
            }

            if ($('#user_email')) {
               $('#user_email').attr('placeholder', '<?php echo !empty($options['email_placeholder']) ? str_replace("'", "\'", $options['email_placeholder']) : ''; ?>');
            }

            if ($('label[for="user_login"]')) {
               console.log($('label[for="user_login"]'));
               $('label[for="user_login"]').html('<?php echo !empty($options['username_label']) ? str_replace("'", "\'", $options['username_label']) : ''; ?>')
            }

            if ($('label[for="user_email"]')) {
               $('label[for="user_email"]').html('<?php echo !empty($options['email_label']) ? str_replace("'", "\'", $options['email_label']) : ''; ?>');
            }

            if ($('#wp-submit')) {
               $('#wp-submit').attr('value', '<?php echo !empty($options['register_button_text']) ? str_replace("'", "\'", $options['register_button_text']) : ''; ?>');
            }

            <?php
            if (!empty($options['rs_subtitle'])) {
               ?>
               document.getElementById('registerform').innerHTML = '<p style="order: -4"><?php echo str_replace("'", "\'", $options['rs_subtitle']); ?></p>' + document.getElementById('registerform').innerHTML;
               <?php
            }

            if (!empty($options['rs_title'])) {
               ?>
               document.getElementById('registerform').innerHTML = '<h2 style="order: -5"><?php echo str_replace("'", "\'", $options['rs_title']); ?></h2>' + document.getElementById('registerform').innerHTML;
               <?php
            }

            ?>
         }
      });
   </script>