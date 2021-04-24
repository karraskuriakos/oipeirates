<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124591046-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-124591046-6');
</script>

<!-- <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script> -->
		
<!--  <script async src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
        appId: "52ad1336-b93d-4bc1-b46f-fcc330a318fe",
        autoRegister: true,
        notifyButton: {
            enable: true,
            /* Required to use the notify button */
            displayPredicate: function() {
                return OneSignal.isPushNotificationsEnabled()
                    .then(function(isPushEnabled) {
                        return !isPushEnabled;
                    });
            },
            size: 'medium',
            /* One of 'small', 'medium', or 'large' */
            theme: 'default',
            /* One of 'default' (red-white) or 'inverse" (white-red) */
            position: 'bottom-right',
            /* Either 'bottom-left' or 'bottom-right' */
            prenotify: true,
            /* Show an icon with 1 unread message for first-time site visitors */
            showCredit: false,
            /* Hide the OneSignal logo */
            text: {
                'tip.state.unsubscribed': 'Εγγραφή στις ενημερώσεις μας.',
                'tip.state.subscribed': "Γραφτήκατε στις ενημερώσεις μας",
                'tip.state.blocked': "Έχετε αποκλείσει τις ενημερώσεις",
                'message.prenotify': 'Κάντε κλικ για να εγγραφείτε στις ενημερώσεις',
                'message.action.subscribed': "Ευχαριστούμε για την εγγραφή σας!",
                'message.action.resubscribed': "Έχετε εγγραφεί στις ενημερώσεις",
                'message.action.unsubscribed': "Δεν θα λάβετε ξανά ενημερώσεις",
                'dialog.main.title': 'Διαχείριση των ειδοποιήσεων ιστότοπου',
                'dialog.main.button.subscribe': 'Εγγραφή',
                'dialog.main.button.unsubscribe': 'Διαγραφή',
                'dialog.blocked.title': 'Απεμπλοκή ενημερώσεων',
                'dialog.blocked.message': "Ακολουθήστε αυτές τις οδηγίες για να επιτρέψετε τις ενημερώσεις μας:"
            }
        },
        welcomeNotification: {
            disable: true
        }
    }]);
</script> 
 -->
		
		<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "52ad1336-b93d-4bc1-b46f-fcc330a318fe",
    });
  });
</script>

		
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php wp_title( ' | ', true, 'right' ); ?></title>
		<?php wptouch_head(); ?>
		<?php
			if ( !is_single() && !is_archive() && !is_page() && !is_search() ) {
				wptouch_canonical_link();
			}

			if ( isset( $_REQUEST[ 'wptouch_preview_theme' ] ) || isset( $_REQUEST[ 'wptouch_switch' ] ) )  {
				echo '<meta name="robots" content="noindex" />';
			}
		?>
	</head>

	<body <?php body_class( wptouch_get_body_classes() ); ?>>


		<?php do_action( 'wptouch_preview' ); ?>

		<?php do_action( 'wptouch_body_top' ); ?>

		<?php get_template_part( 'header-bottom' ); ?>

		<?php do_action( 'wptouch_body_top_second' ); ?>
