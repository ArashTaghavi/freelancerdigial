const Dashboard = () => import('./components/dashboard/index');
const Profile = () => import('./components/profile/index');
const Company = () => import('./components/company/index');
const CompanyShow = () => import('./components/company/show');
const CompanyAttachment = () => import('./components/company/attachment');

const Team = () => import('./components/team/index');
const TeamShow = () => import('./components/team/show');


export default [
    {path: '/dashboard', name: 'داشبورد', component: Dashboard},
    {path: '/profile', name: 'پروفایل', component: Profile},
    {path: '/companies', name: 'شرکت ها', component: Company},
    {path: '/companies/:id/show', name: 'نمایش شرکت', component: CompanyShow},
    {path: '/teams', name: 'تیم ها', component:Team},
    {path: '/teams/:id/show', name: 'نمایش تیم', component: TeamShow},

    {path: '/companies/:id/attachment', name: 'پیوست ها', component: CompanyAttachment}
]
