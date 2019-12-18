const Dashboard = () => import('./components/dashboard/index');
const Profile = () => import('./components/profile/index');
const Company = () => import('./components/company/index');
const CompanyShow = () => import('./components/company/show');
const CompanyAttachment = () => import('./components/company/attachment');

const Project = () => import('./components/project/index');
const ProjectCreate = () => import('./components/project/create');
const ProjectEdit = () => import('./components/project/edit');
const ProjectDetail = () => import('./components/project/detail');

const WorkSamples = () => import('./components/work-sample/work-sample');

const ReservedProject = () => import('./components/reserved-project/index');
const ReservedProjectDetail = () => import('./components/reserved-project/detail');

export default [
    {path: '/dashboard', name: 'داشبورد', component: Dashboard},
    {path: '/profile', name: 'پروفایل', component: Profile},
    {path: '/companies', name: 'شرکت ها', component: Company},
    {path: '/companies/:id/show', name: 'نمایش شرکت', component: CompanyShow},
    {path: '/companies/:id/attachment', name: 'پیوست ها', component: CompanyAttachment},
    {path: '/projects', name: 'پروژه های ارسالی', component: Project},
    {path: '/projects/create', name: 'تعریف پروژه', component: ProjectCreate},
    {path: '/projects/:id/edit', name: 'ویرایش پروژه', component: ProjectEdit},
    {path: '/projects/:id/detail', name: 'جزییات پروژه', component: ProjectDetail},
    {path: '/work-samples', name: 'نمونه کارها', component: WorkSamples},
    {path: '/reserved-projects', name: 'پروژه های دریافتی', component: ReservedProject},
    {path: '/reserved-projects/:id/detail', name: 'جزییات', component: ReservedProjectDetail}

]
