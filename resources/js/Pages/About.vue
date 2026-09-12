
<template>
    <AppLayout
        title="About QFCC"
        description="Learn about Queens Family and Community Center, our mission, vision, and commitment to serving the community."
    >
        <main class="overflow-hidden bg-white">

            <!-- =========================================================
                 HERO SECTION
            ========================================================== -->
            <section class="relative isolate min-h-[620px] overflow-hidden lg:min-h-[680px]">

                <!-- Background Image -->
                <img
                    src="/storage/images/about-hero.jpg"
                    alt="QFCC community gathered together"
                    class="absolute inset-0 h-full w-full object-cover object-center"
                />

                <!-- Gradient Overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-r
                    from-[#002d21]/95
                    via-[#003c2b]/85
                    to-[#00583f]/30"
                ></div>

                <!-- Decorative Glow -->
                <div
                    class="absolute -left-24 top-20 h-72 w-72 rounded-full
                    bg-[#e0ac2e]/10 blur-3xl"
                ></div>

                <div
                    class="absolute bottom-0 right-0 h-96 w-96 rounded-full
                    bg-[#00a878]/10 blur-3xl"
                ></div>

                <!-- Hero Content -->
                <div
                    class="relative mx-auto flex min-h-[620px] max-w-[1280px]
                    items-center px-5 py-20 sm:px-8 lg:min-h-[680px] lg:px-12"
                >
                    <div class="max-w-3xl text-white">

                        <!-- Label -->
                        <div class="mb-6 inline-flex items-center gap-3">
                            <span class="h-px w-10 bg-[#e0ac2e]"></span>

                            <span
                                class="text-xs font-bold uppercase
                                tracking-[0.28em] text-[#e0ac2e]"
                            >
                                About QFCC
                            </span>
                        </div>

                        <!-- Heading -->
                        <h1
                            class="max-w-3xl font-serif text-4xl font-bold
                            leading-[1.08] tracking-tight
                            sm:text-5xl md:text-6xl lg:text-7xl"
                        >
                            Rooted in faith,
                            <span class="block text-[#e0ac2e]">
                                united in service.
                            </span>
                        </h1>

                        <!-- Description -->
                        <p
                            class="mt-7 max-w-2xl text-base leading-8
                            text-white/85 sm:text-lg"
                        >
                            Queens Family and Community Center brings people
                            together to learn, grow, serve, and build a
                            stronger future for every family.
                        </p>

                        <!-- Buttons -->
                        <div class="mt-9 flex flex-wrap gap-4">

                            <a
                                href="#story"
                                class="group inline-flex items-center gap-3
                                rounded-full bg-[#00583f] px-7 py-3.5
                                text-xs font-bold tracking-[0.12em]
                                text-white shadow-lg shadow-black/20
                                transition-all duration-300
                                hover:-translate-y-1 hover:bg-[#007052]
                                hover:shadow-xl"
                            >
                                OUR STORY

                                <i
                                    class="fas fa-arrow-right text-[11px]
                                    transition-transform duration-300
                                    group-hover:translate-x-1"
                                ></i>
                            </a>

                            <a
                                href="index.html#involved"
                                class="group inline-flex items-center gap-3
                                rounded-full bg-[#e0ac2e] px-7 py-3.5
                                text-xs font-bold tracking-[0.12em]
                                text-[#002d21] shadow-lg shadow-black/20
                                transition-all duration-300
                                hover:-translate-y-1 hover:bg-[#f0c34f]
                                hover:shadow-xl"
                            >
                                GET INVOLVED

                                <i
                                    class="fas fa-arrow-right text-[11px]
                                    transition-transform duration-300
                                    group-hover:translate-x-1"
                                ></i>
                            </a>

                        </div>

                    </div>
                </div>

                <!-- Bottom Curve -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-16
                    bg-gradient-to-t from-white/20 to-transparent"
                ></div>
            </section>


            <!-- =========================================================
                 QUICK STATS
            ========================================================== -->
            <section class="relative z-10 -mt-10 px-5 sm:px-8">
                <div
                    class="mx-auto grid max-w-[1100px] overflow-hidden
                    rounded-2xl border border-slate-100 bg-white
                    shadow-[0_20px_60px_rgba(0,65,47,.12)]
                    sm:grid-cols-3"
                >

                    <div
                        class="border-b border-slate-100 px-6 py-7
                        text-center sm:border-b-0 sm:border-r"
                    >
                        <div
                            class="font-serif text-3xl font-bold
                            text-[#00583f]"
                        >
                            Community
                        </div>

                        <p
                            class="mt-1 text-xs font-semibold uppercase
                            tracking-wider text-slate-500"
                        >
                            Built Together
                        </p>
                    </div>

                    <div
                        class="border-b border-slate-100 px-6 py-7
                        text-center sm:border-b-0 sm:border-r"
                    >
                        <div
                            class="font-serif text-3xl font-bold
                            text-[#00583f]"
                        >
                            Faith
                        </div>

                        <p
                            class="mt-1 text-xs font-semibold uppercase
                            tracking-wider text-slate-500"
                        >
                            Guided by Values
                        </p>
                    </div>

                    <div class="px-6 py-7 text-center">
                        <div
                            class="font-serif text-3xl font-bold
                            text-[#00583f]"
                        >
                            Service
                        </div>

                        <p
                            class="mt-1 text-xs font-semibold uppercase
                            tracking-wider text-slate-500"
                        >
                            Driven by Compassion
                        </p>
                    </div>

                </div>
            </section>


            <!-- =========================================================
                 WHO WE ARE
            ========================================================== -->
            <section
                id="story"
                class="relative mx-auto max-w-[1280px]
                px-5 py-20 sm:px-8 lg:px-12 lg:py-28"
            >

                <div
                    class="grid items-center gap-14
                    lg:grid-cols-[0.9fr_1.1fr] lg:gap-20"
                >

                    <!-- Image -->
                    <div class="relative">

                        <!-- Decorative Box -->
                        <div
                            class="absolute -left-4 -top-4 h-full w-full
                            rounded-[28px] border-2 border-[#e0ac2e]/30
                            sm:-left-6 sm:-top-6"
                        ></div>

                        <div
                            class="relative overflow-hidden rounded-[28px]
                            shadow-[0_25px_70px_rgba(0,65,47,.15)]"
                        >
                            <img
                                src="/storage/images/story-mosque.jpg"
                                alt="A mosque and community gathering place"
                                class="h-[360px] w-full object-cover
                                transition duration-700
                                hover:scale-105 sm:h-[500px]"
                            />

                            <div
                                class="absolute inset-0 bg-gradient-to-t
                                from-[#002d21]/45 to-transparent"
                            ></div>
                        </div>

                        <!-- Floating Badge -->
                        <div
                            class="absolute -bottom-6 right-5 rounded-2xl
                            bg-white p-5 shadow-[0_15px_45px_rgba(0,0,0,.12)]
                            sm:right-8"
                        >
                            <div class="flex items-center gap-4">

                                <div
                                    class="flex h-12 w-12 items-center
                                    justify-center rounded-full
                                    bg-[#00583f]/10 text-[#00583f]"
                                >
                                    <i class="fas fa-heart text-lg"></i>
                                </div>

                                <div>
                                    <p
                                        class="text-xs font-bold
                                        uppercase tracking-wider
                                        text-[#00583f]"
                                    >
                                        Our Purpose
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Serving humanity
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>


                    <!-- Content -->
                    <div>

                        <div class="mb-5 flex items-center gap-3">
                            <span class="h-[3px] w-10 bg-[#e0ac2e]"></span>

                            <span
                                class="text-xs font-bold uppercase
                                tracking-[0.22em] text-[#00583f]"
                            >
                                Who We Are
                            </span>
                        </div>

                        <h2
                            class="font-serif text-3xl font-bold leading-tight
                            text-[#00583f] sm:text-4xl lg:text-5xl"
                        >
                            A community built by neighbors,
                            <span class="text-[#e0ac2e]">
                                for neighbors.
                            </span>
                        </h2>

                        <p
                            class="mt-6 text-[15px] leading-8 text-slate-600"
                        >
                            <strong class="text-[#00583f]">
                                Queens Family and Community Center (QFCC)
                            </strong>
                            is a faith-based nonprofit organization dedicated
                            to strengthening families, empowering individuals,
                            and building a compassionate, educated, and united
                            community.
                        </p>

                        <!-- Foundation -->
                        <div
                            class="mt-8 rounded-2xl border border-[#00583f]/10
                            bg-[#f8faf9] p-6"
                        >
                            <div class="flex gap-4">

                                <div
                                    class="flex h-11 w-11 shrink-0
                                    items-center justify-center rounded-xl
                                    bg-[#00583f] text-white shadow-lg"
                                >
                                    <i class="fas fa-mosque"></i>
                                </div>

                                <div>
                                    <h3
                                        class="text-sm font-extrabold
                                        uppercase tracking-wider
                                        text-[#00583f]"
                                    >
                                        Our Foundation
                                    </h3>

                                    <p
                                        class="mt-2 text-sm leading-7
                                        text-slate-600"
                                    >
                                        Guided by the teachings of the
                                        <strong>Holy Qur'an</strong> and the
                                        <strong>
                                            Sunnah of Prophet Muhammad ﷺ
                                        </strong>,
                                        QFCC is committed to serving humanity
                                        with mercy, dignity, justice, and
                                        respect.
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- Values -->
                        <div class="mt-7 grid gap-4 sm:grid-cols-3">

                            <div class="flex items-center gap-3">
                                <i
                                    class="fas fa-circle-check
                                    text-[#e0ac2e]"
                                ></i>

                                <span
                                    class="text-sm font-semibold
                                    text-slate-700"
                                >
                                    Compassion
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <i
                                    class="fas fa-circle-check
                                    text-[#e0ac2e]"
                                ></i>

                                <span
                                    class="text-sm font-semibold
                                    text-slate-700"
                                >
                                    Dignity
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <i
                                    class="fas fa-circle-check
                                    text-[#e0ac2e]"
                                ></i>

                                <span
                                    class="text-sm font-semibold
                                    text-slate-700"
                                >
                                    Service
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </section>


            <!-- =========================================================
                 WHAT WE DO
            ========================================================== -->
            <section
                class="relative overflow-hidden bg-[#f8faf9]
                px-5 py-20 sm:px-8 lg:py-24"
            >

                <!-- Background Decoration -->
                <div
                    class="absolute -right-32 top-10 h-80 w-80
                    rounded-full bg-[#e0ac2e]/10 blur-3xl"
                ></div>

                <div class="relative mx-auto max-w-[1200px]">

                    <div class="mx-auto max-w-3xl text-center">

                        <div
                            class="mb-4 flex items-center justify-center gap-3"
                        >
                            <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>

                            <span
                                class="text-xs font-bold uppercase
                                tracking-[0.22em] text-[#00583f]"
                            >
                                What We Do
                            </span>

                            <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
                        </div>

                        <h2
                            class="font-serif text-3xl font-bold
                            text-[#00583f] sm:text-4xl"
                        >
                            Creating meaningful impact,
                            <span class="text-[#e0ac2e]">
                                together.
                            </span>
                        </h2>

                        <p
                            class="mt-5 text-sm leading-7 text-slate-600
                            sm:text-base"
                        >
                            We work to address the educational, social,
                            spiritual, health, and humanitarian needs of
                            individuals and families throughout Queens and the
                            greater New York City community.
                        </p>

                    </div>


                    <!-- Cards -->
                    <div
                        class="mt-12 grid gap-6 md:grid-cols-3"
                    >

                        <!-- Card 1 -->
                        <article
                            class="group relative overflow-hidden
                            rounded-2xl border border-slate-100 bg-white
                            p-8 shadow-sm transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]"
                        >
                            <div
                                class="absolute right-0 top-0 h-24 w-24
                                rounded-bl-full bg-[#00583f]/5
                                transition group-hover:bg-[#e0ac2e]/10"
                            ></div>

                            <div
                                class="relative flex h-14 w-14 items-center
                                justify-center rounded-2xl bg-[#00583f]/10
                                text-2xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i
                                    class="fas fa-hand-holding-heart"
                                ></i>
                            </div>

                            <h3
                                class="mt-6 text-sm font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                FAITH & SERVICE
                            </h3>

                            <p
                                class="mt-3 text-sm leading-7 text-slate-500"
                            >
                                Serving humanity through Islamic values of
                                mercy, dignity, justice, and respect.
                            </p>

                            <div
                                class="mt-6 h-1 w-10 rounded-full
                                bg-[#e0ac2e] transition-all duration-300
                                group-hover:w-20"
                            ></div>
                        </article>


                        <!-- Card 2 -->
                        <article
                            class="group relative overflow-hidden
                            rounded-2xl border border-slate-100 bg-white
                            p-8 shadow-sm transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]"
                        >
                            <div
                                class="absolute right-0 top-0 h-24 w-24
                                rounded-bl-full bg-[#00583f]/5
                                transition group-hover:bg-[#e0ac2e]/10"
                            ></div>

                            <div
                                class="relative flex h-14 w-14 items-center
                                justify-center rounded-2xl bg-[#00583f]/10
                                text-2xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-users"></i>
                            </div>

                            <h3
                                class="mt-6 text-sm font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                FAMILY & COMMUNITY
                            </h3>

                            <p
                                class="mt-3 text-sm leading-7 text-slate-500"
                            >
                                Strengthening families and connecting
                                neighbors to practical support and
                                opportunity.
                            </p>

                            <div
                                class="mt-6 h-1 w-10 rounded-full
                                bg-[#e0ac2e] transition-all duration-300
                                group-hover:w-20"
                            ></div>
                        </article>


                        <!-- Card 3 -->
                        <article
                            class="group relative overflow-hidden
                            rounded-2xl border border-slate-100 bg-white
                            p-8 shadow-sm transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]"
                        >
                            <div
                                class="absolute right-0 top-0 h-24 w-24
                                rounded-bl-full bg-[#00583f]/5
                                transition group-hover:bg-[#e0ac2e]/10"
                            ></div>

                            <div
                                class="relative flex h-14 w-14 items-center
                                justify-center rounded-2xl bg-[#00583f]/10
                                text-2xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-graduation-cap"></i>
                            </div>

                            <h3
                                class="mt-6 text-sm font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                LEARNING & GROWTH
                            </h3>

                            <p
                                class="mt-3 text-sm leading-7 text-slate-500"
                            >
                                Empowering youth, seniors, newcomers, and
                                individuals through education and leadership.
                            </p>

                            <div
                                class="mt-6 h-1 w-10 rounded-full
                                bg-[#e0ac2e] transition-all duration-300
                                group-hover:w-20"
                            ></div>
                        </article>

                    </div>
                </div>
            </section>


            <!-- =========================================================
                 COMMUNITY + MISSION / VISION
            ========================================================== -->
            <section
                class="mx-auto max-w-[1280px] px-5 py-20
                sm:px-8 lg:px-12 lg:py-28"
            >

                <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

                    <!-- Left -->
                    <div class="flex flex-col justify-center">

                        <div class="mb-5 flex items-center gap-3">
                            <span class="h-[3px] w-10 bg-[#e0ac2e]"></span>

                            <span
                                class="text-xs font-bold uppercase
                                tracking-[0.22em] text-[#00583f]"
                            >
                                Our Community Commitment
                            </span>
                        </div>

                        <h2
                            class="font-serif text-3xl font-bold leading-tight
                            text-[#00583f] sm:text-4xl lg:text-5xl"
                        >
                            Strong families are the foundation of
                            <span class="text-[#e0ac2e]">
                                strong communities.
                            </span>
                        </h2>

                        <p
                            class="mt-6 text-sm leading-8 text-slate-600
                            sm:text-base"
                        >
                            We bring together community members, volunteers,
                            professionals, faith leaders, and partner
                            organizations to provide practical support, build
                            leadership, promote civic engagement, and create
                            opportunities for people to learn, grow, serve,
                            and succeed.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">

                            <span
                                class="rounded-full bg-[#00583f]/10 px-4 py-2
                                text-xs font-semibold text-[#00583f]"
                            >
                                <i class="fas fa-users mr-2"></i>
                                Families
                            </span>

                            <span
                                class="rounded-full bg-[#00583f]/10 px-4 py-2
                                text-xs font-semibold text-[#00583f]"
                            >
                                <i class="fas fa-hands-helping mr-2"></i>
                                Volunteers
                            </span>

                            <span
                                class="rounded-full bg-[#00583f]/10 px-4 py-2
                                text-xs font-semibold text-[#00583f]"
                            >
                                <i class="fas fa-globe mr-2"></i>
                                Community
                            </span>

                        </div>
                    </div>


                    <!-- Right Mission Card -->
                    <div
                        class="relative overflow-hidden rounded-[28px]
                        bg-gradient-to-br from-[#004d37] to-[#002d21]
                        p-8 text-white shadow-[0_25px_70px_rgba(0,65,47,.2)]
                        sm:p-10"
                    >

                        <!-- Decoration -->
                        <div
                            class="absolute -right-20 -top-20 h-56 w-56
                            rounded-full bg-[#e0ac2e]/10"
                        ></div>

                        <div
                            class="absolute -bottom-24 -left-20 h-56 w-56
                            rounded-full bg-white/5"
                        ></div>

                        <div class="relative">

                            <!-- Vision -->
                            <div>
                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-11 w-11 items-center
                                        justify-center rounded-xl
                                        bg-[#e0ac2e] text-[#002d21]"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </div>

                                    <h2
                                        class="font-serif text-2xl font-bold
                                        text-[#e0ac2e]"
                                    >
                                        Our Vision
                                    </h2>

                                </div>

                                <p
                                    class="mt-5 text-sm leading-7
                                    text-white/80"
                                >
                                    To build a compassionate, educated,
                                    empowered, and united community where
                                    individuals and families thrive through
                                    faith, knowledge, service, leadership,
                                    and civic engagement.
                                </p>
                            </div>


                            <div
                                class="my-8 h-px bg-white/10"
                            ></div>


                            <!-- Mission -->
                            <div>

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-11 w-11 items-center
                                        justify-center rounded-xl
                                        bg-[#e0ac2e] text-[#002d21]"
                                    >
                                        <i class="fas fa-bullseye"></i>
                                    </div>

                                    <h2
                                        class="font-serif text-2xl font-bold
                                        text-[#e0ac2e]"
                                    >
                                        Our Mission
                                    </h2>

                                </div>

                                <p
                                    class="mt-5 text-sm leading-7
                                    text-white/80"
                                >
                                    QFCC is dedicated to serving humanity
                                    through the teachings of the
                                    <strong>Holy Qur'an</strong> and the
                                    <strong>
                                        Sunnah of Prophet Muhammad ﷺ
                                    </strong>.
                                </p>


                                <!-- Mission List -->
                                <ul class="mt-5 space-y-3">

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Strengthening families and building
                                        healthy communities.
                                    </li>

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Providing educational and lifelong
                                        learning opportunities.
                                    </li>

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Supporting youth, seniors, and
                                        vulnerable individuals.
                                    </li>

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Assisting immigrants and newcomers
                                        with dignity and respect.
                                    </li>

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Promoting health, wellness,
                                        volunteerism, and civic engagement.
                                    </li>

                                    <li
                                        class="flex gap-3 text-sm
                                        leading-6 text-white/80"
                                    >
                                        <i
                                            class="fas fa-check-circle
                                            mt-1 shrink-0 text-[#e0ac2e]"
                                        ></i>

                                        Providing humanitarian relief and
                                        building partnerships for peace and
                                        cooperation.
                                    </li>

                                </ul>

                            </div>

                        </div>
                    </div>

                </div>
            </section>


            <!-- =========================================================
                 OUR COMMITMENT
            ========================================================== -->
            <section
                class="relative overflow-hidden bg-[#f8faf9]
                px-5 py-20 sm:px-8 lg:py-24"
            >

                <div class="relative mx-auto max-w-[1200px]">

                    <div class="mx-auto max-w-3xl text-center">

                        <div
                            class="mb-4 flex items-center justify-center gap-3"
                        >
                            <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>

                            <span
                                class="text-xs font-bold uppercase
                                tracking-[0.22em] text-[#00583f]"
                            >
                                Our Commitment
                            </span>

                            <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
                        </div>

                        <h2
                            class="font-serif text-3xl font-bold
                            text-[#00583f] sm:text-4xl"
                        >
                            Serving with Faith,
                            <span class="text-[#e0ac2e]">
                                Compassion & Excellence.
                            </span>
                        </h2>

                        <p
                            class="mt-5 text-sm leading-7 text-slate-600
                            sm:text-base"
                        >
                            At Queens Family and Community Center, we believe
                            meaningful service begins with compassion and is
                            sustained through trust, collaboration, and
                            excellence.
                        </p>

                    </div>


                    <!-- Commitment Cards -->
                    <div
                        class="mt-12 grid gap-5 sm:grid-cols-2
                        lg:grid-cols-4"
                    >

                        <!-- Partnership -->
                        <article
                            class="group rounded-2xl border border-slate-100
                            bg-white p-7 text-center shadow-sm
                            transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]"
                        >
                            <div
                                class="mx-auto flex h-14 w-14 items-center
                                justify-center rounded-2xl
                                bg-[#00583f]/10 text-xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-handshake"></i>
                            </div>

                            <h3
                                class="mt-5 text-xs font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                COMMUNITY PARTNERSHIPS
                            </h3>

                            <p
                                class="mt-3 text-sm leading-6 text-slate-500"
                            >
                                Working together with nonprofits, schools,
                                healthcare organizations, and civic leaders.
                            </p>
                        </article>


                        <!-- Compassion -->
                        <article
                            class="group rounded-2xl border border-slate-100
                            bg-white p-7 text-center shadow-sm
                            transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]"
                        >
                            <div
                                class="mx-auto flex h-14 w-14 items-center
                                justify-center rounded-2xl
                                bg-[#00583f]/10 text-xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-heart"></i>
                            </div>

                            <h3
                                class="mt-5 text-xs font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                COMPASSIONATE SERVICE
                            </h3>

                            <p
                                class="mt-3 text-sm leading-6 text-slate-500"
                            >
                                Treating every individual with dignity,
                                kindness, respect, and care.
                            </p>
                        </article>


                        <!-- Sustainable -->
                        <article
                            class="group rounded-2xl border border-slate-100
                            bg-white p-7 text-center shadow-sm
                            transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]"
                        >
                            <div
                                class="mx-auto flex h-14 w-14 items-center
                                justify-center rounded-2xl
                                bg-[#00583f]/10 text-xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-seedling"></i>
                            </div>

                            <h3
                                class="mt-5 text-xs font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                SUSTAINABLE IMPACT
                            </h3>

                            <p
                                class="mt-3 text-sm leading-6 text-slate-500"
                            >
                                Developing long-term programs that empower
                                individuals and families.
                            </p>
                        </article>


                        <!-- Open -->
                        <article
                            class="group rounded-2xl border border-slate-100
                            bg-white p-7 text-center shadow-sm
                            transition-all duration-300
                            hover:-translate-y-2
                            hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]"
                        >
                            <div
                                class="mx-auto flex h-14 w-14 items-center
                                justify-center rounded-2xl
                                bg-[#00583f]/10 text-xl text-[#00583f]
                                transition duration-300
                                group-hover:bg-[#00583f]
                                group-hover:text-white"
                            >
                                <i class="fas fa-globe-americas"></i>
                            </div>

                            <h3
                                class="mt-5 text-xs font-extrabold
                                tracking-wider text-[#00583f]"
                            >
                                OPEN TO ALL
                            </h3>

                            <p
                                class="mt-3 text-sm leading-6 text-slate-500"
                            >
                                Welcoming people of all backgrounds while
                                remaining guided by Islamic values.
                            </p>
                        </article>

                    </div>


                    <!-- Quote -->
                    <div class="mt-14 text-center">

                        <div
                            class="mx-auto mb-5 flex h-12 w-12 items-center
                            justify-center rounded-full bg-[#e0ac2e]/15
                            text-[#e0ac2e]"
                        >
                            <i class="fas fa-quote-left"></i>
                        </div>

                        <blockquote
                            class="mx-auto max-w-3xl font-serif text-lg
                            italic leading-8 text-[#00583f] sm:text-xl"
                        >
                            "Together, we strive to build a community where
                            every individual has the opportunity to learn,
                            grow, contribute, and succeed."
                        </blockquote>

                    </div>

                </div>
            </section>


            <!-- =========================================================
                 FINAL CTA
            ========================================================== -->
            <section class="px-5 py-16 sm:px-8 lg:py-24">

                <div
                    class="relative mx-auto max-w-[1200px] overflow-hidden
                    rounded-[30px] bg-gradient-to-br
                    from-[#00583f] to-[#002d21]
                    shadow-[0_25px_70px_rgba(0,65,47,.2)]"
                >

                    <!-- Decorative Shapes -->
                    <div
                        class="absolute -right-20 -top-20 h-72 w-72
                        rounded-full bg-[#e0ac2e]/10"
                    ></div>

                    <div
                        class="absolute -bottom-28 -left-20 h-72 w-72
                        rounded-full bg-white/5"
                    ></div>

                    <div
                        class="relative grid items-center
                        lg:grid-cols-[1.1fr_.9fr]"
                    >

                        <!-- Copy -->
                        <div class="p-8 sm:p-12 lg:p-14">

                            <div
                                class="mb-5 flex h-14 w-14 items-center
                                justify-center rounded-2xl bg-[#e0ac2e]
                                text-xl text-[#002d21]"
                            >
                                <i class="fas fa-heart"></i>
                            </div>

                            <p
                                class="text-xs font-bold uppercase
                                tracking-[0.22em] text-[#e0ac2e]"
                            >
                                Make A Difference
                            </p>

                            <h2
                                class="mt-3 font-serif text-3xl font-bold
                                text-white sm:text-4xl"
                            >
                                Be part of the
                                <span class="text-[#e0ac2e]">
                                    QFCC community.
                                </span>
                            </h2>

                            <p
                                class="mt-5 max-w-xl text-sm leading-7
                                text-white/75 sm:text-base"
                            >
                                Whether you share your time, your skills, or
                                your support, there is a place for you here.
                                Together, we can create meaningful and lasting
                                change.
                            </p>

                            <a
                                href="index.html#involved"
                                class="group mt-7 inline-flex items-center
                                gap-3 rounded-full bg-[#e0ac2e] px-7 py-3.5
                                text-xs font-bold tracking-[0.12em]
                                text-[#002d21]
                                transition-all duration-300
                                hover:-translate-y-1 hover:bg-[#f0c34f]"
                            >
                                GET INVOLVED

                                <i
                                    class="fas fa-arrow-right
                                    transition-transform duration-300
                                    group-hover:translate-x-1"
                                ></i>
                            </a>

                        </div>


                        <!-- Image -->
                        <div class="relative h-[300px] lg:h-full lg:min-h-[390px]">

                            <img
                                src="/storage/images/why-family.jpg"
                                alt="QFCC families and community members"
                                class="absolute inset-0 h-full w-full
                                object-cover"
                            />

                            <div
                                class="absolute inset-0 bg-gradient-to-r
                                from-[#002d21]/30 to-transparent"
                            ></div>

                        </div>

                    </div>

                </div>
            </section>

        </main>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>
