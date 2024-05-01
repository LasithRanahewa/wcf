<?php
$cartItemCount = 0; // logic to get the count of items in the cart;
$cartItemCount = $_SESSION['cart']->cart_item_count;
?>

<style>
  .nav {
    height: var(--header-height);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .nav__img {
    width: 32px;
    border-radius: 50%;
  }

  .nav__logo {
    color: var(--title-color);
    font-weight: 600;
    cursor: pointer;
  }

  .nav__list,
  .nav__link {
    display: flex;
  }

  .nav__link {
    flex-direction: column;
    align-items: center;
    row-gap: 4px;
    color: var(--title-color);
    font-weight: 500;
  }

  .nav__list {
    justify-content: space-around;
    margin-right: 10px;
  }

  .nav__menu {
    display: flex;
    justify-content: space-between;
  }

  .nav__item {
    margin: 10px 25px;
  }

  .nav__name {
    font-size: 14px
  }

  .nav__icon {
    font-size: 1.5rem;
  }

  /*Active link*/
  .active-link {
    position: relative;
    color: var(--first-color);
    transition: .3s;
  }

  /* Change background header */
  .scroll-header {
    box-shadow: 0 1px 12px hsla(var(--hue), var(--sat), 15%, 0.15);
  }

  .navl-cont img {
    max-height: 50px;
    min-height: 30px;
    padding: 10px;
  }

  .navl-cont:hover .nav__logo {
    color: var(--first-color);
  }

  .cart-count {
    padding: 5px;
    border-radius: 10px;
    background-color: var(--red);
    font-size: 8px;
  }

  /* Media Queries */
  @media screen and (min-width: 750px) {
    .nav__link .nav__icon {
      display: none;
      /* Hide icons */
    }

    .nav__name {
      display: block;
      /* Display navigation names */
    }
  }

  @media screen and (max-width: 751px) {
    .nav__link .nav__icon {
      display: flex;
      /* Display icons */
    }

    .nav__name {
      display: none;
      /* Hide navigation names */
    }
  }

  .navl-cont {
    display: flex;
    justify-content: start;
    align-items: center;
  }

  .navl-cont:hover .navi__logo {
    color: var(--first-color);
  }
</style>

<header class="header" id="header">
  <nav style="width:100%" class="nav container">
    <div class="navl-cont">
      <!-- <img src="<?php echo ROOT ?>/assets/images/Logo_green.png"> -->
      <a href="<?= ROOT ?>" class="naiv_logo material-icons-outlined" style="font-size: 30px; font-weight: 400; color: var(--primary);"> living </a> <a class="navi_logo" style=" font-weight: 600;padding-left: 5px ;color: var(--primary);"> WoodCraft Furnitures </a>
    </div>

    <div class="nav__menu" id="nav-menu">
      <ul class="nav__list">
        <li class="nav__item">
          <a href="<?php echo ROOT ?>" class="nav__link active-link">
            <span class="material-symbols-outlined nav__icon">
              home
            </span>
            <span class="nav__name">Home</span>
          </a>
        </li>

        <li class="nav__item">
          <a href="<?= ROOT ?>" class="nav__link">
            <span class="material-symbols-outlined nav__icon">
              chair
            </span>
            <span class="nav__name">Products</span>
          </a>
        </li>

        <li class="nav__item">
          <a href="<?php echo ROOT ?>/orders" class="nav__link">
            <span class="material-symbols-outlined nav__icon">
              package
            </span>
            <span class="nav__name">Orders</span>
          </a>
        </li>

        <li class="nav__item">
          <a href="<?php echo ROOT ?>/cart" class="nav__link">
            <span class="material-symbols-outlined nav__icon">shopping_cart</span>
            <span class="nav__name">Cart</span>
          </a>
        </li>

        <?php if (!Auth::logged_in()) : ?>
          <li class="nav__item">
            <a href="<?php echo ROOT ?>/login" class="nav__link">
              <span class="material-symbols-outlined nav__icon">
                login
              </span>
              <span class="nav__name">Log In</span>
            </a>
          </li>

          <li class="nav__item">
            <a href="<?php echo ROOT ?>/logout" class="nav__link">
              <span class="material-symbols-outlined nav__icon">
                person_add
              </span>
              <span class="nav__name">Sign Up</span>
            </a>
          </li>

        <?php else : ?>
          <li class="nav__item">
            <a href="<?php echo ROOT ?>/profile" class="nav__link">
              <span class="material-symbols-outlined nav__icon">
                account_circle
              </span>
              <span class="nav__name">Profile</span>
            </a>
          </li>

          <li class="nav__item">
            <a href="<?php echo ROOT ?>/logout" class="nav__link">
              <span class="material-symbols-outlined nav__icon">
                logout
              </span>
              <span class="nav__name">Log out</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>

<script>
  // Add event listener to the parent element
  document.querySelector('.nav-main').addEventListener('click', (event) => {
    const target = event.target;
    const id = target.id;

    // Handle different menu items based on their IDs
    switch (id) {
      case 'tohome':
        window.location.href = '<?= ROOT ?>';
        break;
      case 'toproducts':
        window.location.href = '<?= ROOT ?>/products';
        break;
      case 'toabout':
        window.location.href = '<?= ROOT ?>/about';
        break;
      case 'tocontact':
        window.location.href = '<?= ROOT ?>/contact';
        break;
      case 'tocart':
        window.location.href = '<?= ROOT ?>/cart';
        break;
      case 'tomanage-acc':
        window.location.href = '<?= ROOT ?>/profile';
        break;
      case 'toprofile':
        window.location.href = '<?= ROOT ?>/profile/myProfile';
        break;
      case 'toregister':
        window.location.href = '<?= ROOT ?>/signup';
        break;
      case 'tologin':
        window.location.href = '<?= ROOT ?>/login';
        break;
        // case 'tologout':
        //     window.location.href = '<?= ROOT ?>/logout';
        //     break;
      case 'toorders':
        window.location.href = '<?= ROOT ?>/orders';
        break;
      case 'tobulk':
        window.location.href = '<?= ROOT ?>/orders/bulkOrders';
        break;
      case 'toreviews':
        window.location.href = '<?= ROOT ?>/review';
        break;
        // case 'toreturns':
        //     window.location.href = '<?= ROOT ?>/profile/returns';
        //     break;
      default:
        break;
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Find the logout button
    const logoutButton = document.querySelector('#tologout button');

    // Add a click event listener to the logout button
    logoutButton.addEventListener('click', function() {
      // Perform a direct navigation to a URL that will trigger logout
      window.location.href = '<?= ROOT ?>/logout';
    });
  });
</script>

<script src="<?php echo ROOT ?>/assets/js/header.js"></script>