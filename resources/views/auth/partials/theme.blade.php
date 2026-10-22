<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --navy-deep: #172b4d;
        --navy-mid: #223d65;
        --navy-soft: #365c8e;
        --amber: #f3b33d;
        --amber-soft: #ffd778;
        --paper: #f7f5ef;
        --ink: #26364b;
        --slate: #7d8797;
    }
    html, body { min-height: 100%; font-family: 'Poppins', sans-serif !important; color: var(--ink); }
    body { min-height: 100vh; background: var(--navy-deep) !important; }
    .hero {
        position: relative; isolation: isolate; min-height: 100vh;
        padding: clamp(36px, 6vw, 82px) !important;
        background: radial-gradient(ellipse at 12% 10%, #ffffff12, transparent 42%),
                    linear-gradient(135deg, #223d65 0%, #172b4d 58%, #101a33 100%) !important;
    }
    .hero::before, .hero::after { content: ''; position: absolute; z-index: -1; border: 1px solid #ffffff12; border-radius: 50%; pointer-events: none; }
    .hero::before { width: 460px; height: 460px; top: 10%; right: -170px; }
    .hero::after { width: 320px; height: 320px; top: calc(10% + 70px); right: -100px; }
    .hero svg.skyline { opacity: .48; }
    .hero .moon { width: 58px; height: 58px; background: var(--amber); box-shadow: 0 0 70px 18px #f3b33d30; }
    .hero-content { max-width: 440px; }
    .hero-content .eyebrow-mark { width: 36px; height: 3px; margin-bottom: 14px; border-radius: 4px; background: var(--amber); }
    .hero-content h1 { color: #fff !important; font: 700 clamp(27px, 3vw, 38px)/1.2 'Poppins', sans-serif !important; letter-spacing: -.04em; }
    .hero-content p { color: #d3dbea !important; font-size: 13px; line-height: 1.65; }
    .panel {
        flex: 0 0 48%; min-width: 460px; min-height: 100vh; padding: clamp(18px, 3vw, 42px) !important;
        background: var(--paper) !important; overflow-y: auto;
    }
    .form-card {
        position: relative;
        width: 100%; max-width: 450px; padding: clamp(20px, 2.5vw, 30px);
        border: 1px solid #e8eaf0; border-radius: 18px; background: #fff;
        box-shadow: 0 18px 50px #172b4d12;
    }
    .auth-back-button { position: absolute; top: 14px; right: 14px; display: inline-grid; place-items: center; width: 34px; height: 34px; padding: 0; border: 1px solid #d8deea; border-radius: 8px; background: #fff; color: var(--navy-deep); cursor: pointer; }
    .auth-back-button:hover { background: #f5f7fb; }
    .auth-back-button i { font-size: 13px; line-height: 1; }
    .form-card .mark { margin-bottom: 18px !important; }
    .form-card .mark .key-badge { width: 42px; height: 42px; border-radius: 13px; background: var(--navy-deep) !important; }
    .form-card .mark span { color: var(--navy-deep) !important; font-size: 12px !important; font-weight: 700 !important; letter-spacing: .01em; }
    .form-card h2 { color: var(--navy-deep) !important; font: 700 24px/1.25 'Poppins', sans-serif !important; letter-spacing: -.03em; }
    .form-card > p.sub { color: var(--slate) !important; font-size: 12px !important; line-height: 1.55; }
    .form-group label { color: #34445d !important; font-size: 11px !important; font-weight: 600 !important; }
    .form-group input, .form-group select {
        min-height: 42px; border: 1px solid #e1e6ef !important; border-radius: 9px !important;
        background-color: #fff !important; color: var(--ink) !important; font: 400 12px 'Poppins', sans-serif !important;
    }
    .form-group input:focus, .form-group select:focus { border-color: var(--amber) !important; box-shadow: 0 0 0 4px #f3b33d2b !important; }
    .form-group input::placeholder { color: #9aa4b4 !important; }
    .password-toggle { border: 0; background: transparent; }
    .password-toggle:hover { background: #fff5df !important; }
    .remember-me label, .forgot-link, .footer-text { font-size: 12px !important; }
    .forgot-link, .footer-text a { color: var(--navy-deep) !important; }
    .btn-submit {
        min-height: 42px; border-radius: 9px !important; background: var(--navy-deep) !important;
        color: #fff !important; font: 600 12px 'Poppins', sans-serif !important;
        box-shadow: 0 7px 16px #172b4d20; transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .btn-submit:hover { background: var(--navy-mid) !important; transform: translateY(-1px); box-shadow: 0 10px 22px #172b4d26; }
    .alert-success, .alert-error { border-radius: 11px !important; font-size: 12px !important; line-height: 1.6; }
    .alert-error { background: #fff2f0 !important; border-color: #f1d0cc !important; }
    .field-error { margin-top: 5px; color: #a33a32; font-size: 11px; }
    .footer-text { margin-top: 20px !important; }
    .form-card form { gap: 10px; }
    .form-card .form-group { margin-bottom: 10px; }
    .form-meta-row { gap: 12px; }
    :focus-visible { outline-color: var(--amber); outline-offset: 3px; }
    @media (max-width: 860px) {
        body { flex-direction: column; }
        .hero { min-height: 210px !important; padding: 30px 24px !important; }
        .hero-content h1 { font-size: 26px !important; }
        .hero-content p { display: block !important; max-width: 480px; font-size: 12px; }
        .hero .moon { top: 28px; right: 30px; width: 38px; height: 38px; }
        .hero::before { width: 230px; height: 230px; top: -70px; right: -70px; }
        .hero::after { display: none; }
        .panel { min-width: 0 !important; min-height: calc(100vh - 210px); padding: 24px 16px 36px !important; }
        .form-card { max-width: 500px; margin: auto; }
    }
    @media (max-width: 480px) {
        .hero { min-height: 178px !important; padding: 24px 20px !important; }
        .hero-content h1 { font-size: 23px !important; }
        .hero-content p { font-size: 11px; }
        .hero .moon { right: 20px; top: 20px; width: 30px; height: 30px; }
        .panel { min-height: calc(100vh - 178px); padding: 16px 12px 28px !important; }
        .form-card { padding: 22px 18px; border-radius: 17px; }
        .form-card .mark { margin-bottom: 22px !important; }
        .form-card .mark span { font-size: 11px !important; }
        .form-meta-row { gap: 10px; }
        .remember-me label, .forgot-link { font-size: 11px !important; }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-page-back]').forEach(button => {
            button.addEventListener('click', () => {
                const referrer = document.referrer;
                if (referrer && new URL(referrer).origin === window.location.origin) {
                    window.history.back();
                    return;
                }

                window.location.href = button.dataset.fallback;
            });
        });
    });
</script>
