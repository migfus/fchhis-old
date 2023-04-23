<template>
  <section class="content mb-5">
    <div class="card">
      <div class="card-body">
        <div class="error-page">
          <h2 class="headline text-warning"> 404</h2>
          <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
            <p>
              We could not find the page you were looking for.
              Meanwhile, you may <RouterLink :to="{ name: 'home' }">return to home page.</RouterLink>
            </p>

          </div>

        </div>
      </div>
    </div>


  </section>
</template>
