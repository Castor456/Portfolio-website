// Smooth nav toggling and smooth scroll + AJAX contact submit
document.addEventListener('DOMContentLoaded', function(){
  // nav toggle
const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.site-nav');

toggle && toggle.addEventListener('click', () => {
  nav.classList.toggle('open');
});

// smooth scroll for nav links
document.querySelectorAll('.site-nav a').forEach(a => {
  a.addEventListener('click', function(e) {
    const href = this.getAttribute('href');

    if (href.startsWith('#')) {
      e.preventDefault();
      const el = document.querySelector(href);
      if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Close the menu on mobile
    if (window.innerWidth <= 880) {
      nav.classList.remove('open');
    }
  });
});

  // contact form AJAX
  const form = document.getElementById('contact-form');
  const statusBox = document.getElementById('status-box');
  function showStatus(message, ok=true){
    statusBox.hidden = false;
    statusBox.className = 'status-box ' + (ok ? 'success' : 'error');
    statusBox.textContent = message;
    if(ok) setTimeout(()=>{ statusBox.hidden = true; }, 8000);
  }

  form && form.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(form);
    if(!formData.get('name') || !formData.get('email') || !formData.get('message')){
      showStatus('Please fill all required fields.', false);
      return;
    }
    fetch('submit.php', {method:'POST', body:formData, credentials:'same-origin'})
      .then(r=>r.json())
      .then(data=>{
        if(data.success){ form.reset(); showStatus(data.message || 'Message sent!', true); }
        else showStatus(data.message || 'Submission failed.', false);
      }).catch(err=>{ console.error(err); showStatus('Network error. Try later.', false); });
  });
});