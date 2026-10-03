<?php
/**
 * All site content. Edit this file to change text, projects, jobs, studies and skills —
 * every section reads from here.
 */

$site = [
    'name' => 'Jop Mörs',
    'fullName' => 'Developer · Designer · Problem Solver',
    'role' => 'Developer · Designer · Problem Solver',
    'url' => 'https://example.com',
    'description' => 'I build modern digital experiences with a focus on design, performance and usability.',
    'email' => 'jop.mors@icloud.com',
    'socials' => [
        'github' => 'https://github.com/JopMors',
        'linkedin' => 'https://www.linkedin.com/in/jop-m%C3%B6rs-5170b5294/?skipRedirect=true',
    ],
];

/**
 * Projects. status: "launched" or "ongoing" — the Work section groups them.
 * A launched project with a 'slug' gets its own page at projects/<slug>/
 * (page content in includes/projects/<slug>.php).
 * Leave github/demo as null until you have a link; 'demoLabel' renames the demo button.
 */
$projects = [
    [
        'slug' => 'spindle',
        'title' => 'Spindle',
        'description' => 'A macOS desktop widget-like app shaped like a 2000s-era portable music player. It shows whatever is playing, from any app, with a working scroll wheel.',
        'technologies' => ['Swift', 'Objective-C', 'macOS', 'Spotify Web API'],
        'github' => 'https://github.com/JopMors/Spindle',
        'demo' => 'https://github.com/JopMors/Spindle/releases/latest',
        'demoLabel' => 'Download',
        'status' => 'launched',
        'version' => '2.5.0',
        'icon' => 'assets/img/projects/spindle/icon.png',
        'image' => 'assets/img/projects/spindle/skins.png',
        'imageAlt' => 'Four of the nine Spindle skins',
        'visual' => 'ipod',
        'tint' => '92 84 200',
    ],
    [
        'slug' => 'thesis',
        'title' => 'MASTER-X',
        'description' => 'My BSc thesis: a multi-agent reinforcement learning redesign for prescriptive process monitoring. Every employee in a business process becomes an agent that decides whether to volunteer for the next task. Main finding: when the reward fires matters more than which algorithm you pick.',
        'technologies' => ['Python', 'PyTorch', 'PettingZoo', 'MAPPO · QMIX · COMA', 'Process mining'],
        'github' => 'https://github.com/JopMors/MASTER-X',
        'demo' => 'assets/docs/thesis-jop-mors.pdf',
        'demoLabel' => 'Read the thesis',
        'status' => 'launched',
        'statusLabel' => 'BSc thesis · Grade 8.1',
        'icon' => 'assets/img/projects/thesis/uu-logo.png',
        'image' => 'assets/img/projects/thesis/cover.webp',
        'imageAlt' => 'Title page of the thesis: Advancing Prescriptive Process Monitoring: A Multi-Agent Reinforcement Learning Redesign',
        'visual' => 'paper',
        'tint' => '190 60 80',
    ],
    [
        'title' => 'Gargantua',
        'description' => 'A local-first agentic workspace for my Mac: chat, a coding agent, my Obsidian vault, my projects and local image and video generation in one app, with no cloud inference. ORBIT, its background agent, reads my most active projects and prepares recommendations and drafts on its own.',
        'technologies' => ['Next.js', 'TypeScript', 'Python', 'FastAPI', 'Ollama', 'ComfyUI'],
        'github' => null,
        'demo' => null,
        'status' => 'ongoing',
    ],
    [
        'title' => 'Hondenschool Kim',
        'description' => 'Client work for a dog school in Ermelo: a public website with course registration, a private members\' area where participants stream training videos for their own courses, and an admin back office with a dashboard, CSV export and user roles.',
        'technologies' => ['PHP', 'MySQL', 'JavaScript', 'Node.js', 'SQLite'],
        'closedSource' => true,
        'demo' => 'https://hondenschoolkim.nl',
        'demoLabel' => 'Go to website',
        'status' => 'ongoing',
    ],
];

/** The About me section. Swap the photo in assets/img/about/. */
$about = [
    'portrait' => 'assets/img/about/portrait_color.jpeg',
    'portraitAlt' => 'Jop Mörs in front of the Duomo in Milan',
    'headline' => "I'm Jop.",
    'headlineAccent' => 'I like the intersections.',
    'paragraphs' => [
        'I studied Information Science at Utrecht University and stayed on for a master\'s in Business Informatics. What keeps pulling me back is the same in every project on this page: Making small parts of life that little bit more easy, efficient, or just more beautiful. The interesting problem is almost never inside one layer, it is where two of them meet.',
        'In my thesis it was where game theory meets process data: a reward that fires at the wrong moment makes every algorithm look identical. In Spindle (see projects) it was making an app that combines nostalgia and functionality for the click wheel, which turns out to be physics rather than design.',
        'I build things end to end, I use Python, Swift, JS, PHP, SQL, CSS, and I read my own results, including the ones that say something did not work. Two of the three algorithms in my thesis failed, and those failures were more interesting than the success.',
        'Next to my studies, I work with data and Power BI at Zuyderland, and occasionally, I build websites for clients. Outside of that: American football, Fitness, Music and Games interest me. Thus those are usually the domains I end up building things for. Either for hobby or for given Projects',
    ],
    'facts' => [
        ['Based in', 'Utrecht & Limburg, NL'],
        ['Studying', 'MSc Business Informatics'],
        ['Speaks', 'Dutch · English'],
        ['Interested in', 'Process mining · RL · web'],
    ],
];

$skills = [
    ['name' => 'Python', 'logo' => 'assets/img/logos/python.svg'],
    ['name' => 'HTML', 'logo' => 'assets/img/logos/html5.svg'],
    ['name' => 'CSS', 'logo' => 'assets/img/logos/css3.svg'],
    ['name' => 'PHP', 'logo' => 'assets/img/logos/php.svg'],
    ['name' => 'JavaScript', 'logo' => 'assets/img/logos/javascript.svg'],
    ['name' => 'C', 'logo' => 'assets/img/logos/c.svg'],
    ['name' => 'C#', 'logo' => 'assets/img/logos/csharp.svg'],
];

/**
 * "What I do" and Capabilities, in process order. `id` picks the drawing (design / application / data);
 * `tools` fill the Capabilities cards; `tint` (an RGB triplet, kept close to white) colours
 * the step's line drawing and its tool chips.
 */
$capabilities = [
    [
        'id' => 'design',
        'title' => 'Design',
        'line' => 'Work out what it should do, and how it should feel.',
        'detail' => 'Layout, typography and motion treated as part of the engineering, not an afterthought. I think its a shame when a program has a lot of features that nobody wants or needs and therefore nobody uses. Thats why I want to speak to the end users first, then think of a solution, and discussing what I think could be usefull and possible.',
        'tools' => ['Figma', 'CSS', 'BPMN', 'Process modelling'],
        'tint' => '232 221 204',
    ],
    [
        'id' => 'application',
        'title' => 'Application',
        'line' => 'Websites and apps, built end to end.',
        'detail' => 'Build software that is useful, reliable, and feels right to use. I enjoy working across the stack, from shaping the interface and user experience to building the logic behind it. Whether it is a website, application, or a native tool, I focus on keeping the technology purposeful rather than adding complexity for its own sake. The Front-end craft in HTML, CSS and JavaScript, backed by PHP and Python, and native apps in Swift.',
        'tools' => ['HTML', 'CSS', 'JavaScript', 'Swift', 'PHP', 'Python', 'C#'],
        'tint' => '206 218 238',
    ],
    [
        'id' => 'data',
        'title' => 'Data',
        'line' => 'Turn what actually happens into decisions.',
        'detail' => 'Make sense of what is happening and use it to make better decisions. I work with data from collection and modelling to analysis and visualisation, looking for patterns, inefficiencies, and insights that are actually useful. Sometimes the most valuable result is discovering that an approach does not work, and understanding why.',
        'tools' => ['SQL', 'Power BI', 'Python', 'C'],
        'tint' => '207 230 215',
    ],
];

$experience = [
    [
        'company' => 'Zuyderland Ziekenhuis',
        'role' => 'ICT - Power BI Developer',
        'period' => '2024 – Present',
        'description' => 'I am currently working as a Power BI Developer at Zuyderland Ziekenhuis, where I am responsible for developing and maintaining data visualization solutions to support decision-making processes within the organization. My role involves collaborating with various departments to understand their data needs and translating them into actionable insights through interactive dashboards and reports.',
    ],
    [
        'company' => 'Utrecht University',
        'role' => 'TA - Teaching assistant',
        'period' => '2023 – 2026',
        'description' => 'I have helped teaching and grading at bachelor level. I have done 2 periods of process modelling, 1 course or data analytics and 1 course of code',
    ],
    [
        'company' => 'Wolfhagen Maasbracht',
        'role' => 'Sales Associate',
        'period' => '2019 – 2024',
        'description' => 'During my time at Wolfhagen Maasbracht, I worked as a Sales Associate, where I was responsible for assisting customers with their purchases, providing product information, and ensuring a positive shopping experience. I developed strong communication and interpersonal skills while working in a fast-paced retail environment.',
    ],
];

$education = [
    [
        'institution' => 'Utrecht University',
        'degree' => 'Master — Business Informatics',
        'period' => '2026 – Present',
        'detail' => "A two-year master on the seam between information systems, business and software. Where the bachelor taught me how information systems work, the master is about designing and governing them inside organisations: data science and its impact on society, data-intensive systems, business process management, method engineering and requirements engineering. I want my MSc thesis to continue the process-mining line of my BSc thesis.",
    ],
    [
        'institution' => 'BSc Thesis',
        'degree' => 'Advancing Prescriptive Process Monitoring: A Multi-Agent Reinforcement Learning Redesign',
        'period' => '2025 – 2026',
        'detail' => 'Sole author, supervised by Dr. ir. Claudio Di Ciccio and Dr. ir. Xixi Lu at Utrecht University. I redesigned the reward, the observation space and the algorithm comparison of MASTER, a multi-agent RL environment for assigning tasks in business processes. MAPPO closed 65% of the gap between random assignment and the best heuristic. Graded 8.1.',
        'link' => ['href' => 'projects/thesis/', 'label' => 'Read about the thesis'],
    ],
    [
        'institution' => 'Utrecht University',
        'degree' => 'Bachelor — Information Science',
        'period' => '2023 – 2026',
        'detail' => "I have pursued a Bachelor's degree in Information Science at Utrecht University, focusing on the study of information systems, data management, and technology's impact on society. The program provides a comprehensive understanding of how information is created, processed, and utilized in various contexts.",
    ],
    [
        'institution' => 'Connect College',
        'degree' => 'VWO - Science & Technology',
        'period' => '2017 – 2023',
        'detail' => 'Completed my pre-university education (VWO) at Connect College, specializing in Science & Technology. The curriculum provided a strong foundation in mathematics, physics, and science/biology, preparing me for further studies in the field of information science and technology.',
    ],
];
