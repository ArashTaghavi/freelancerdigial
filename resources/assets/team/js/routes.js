const Dashboard = () => import('./components/dashboard/index');
const Profile = () => import('./components/profile/index');
const Team = () => import('./components/team/index');
const TeamCreate = () => import('./components/team/create');
const TeamEdit = () => import('./components/team/edit');
const TeamAttachment = () => import('./components/team/attachment');
const TeamReview = () => import('./components/team/review');
const TeamWorkSample = () => import('./components/team/work-sample');
const TeamMember = () => import('./components/team/member');
const TeamReservedProject = () => import('./components/team/project/detail-reserved-project');
const TeamReservedProjectIndex = () => import('./components/team/project/index-reserved-project');
const TeamProject = () => import('./components/team/project/detail-project');
const TeamProjectIndex = () => import('./components/team/project/index-project');
const TeamProjectCreate = () => import('./components/team/project/create-project');
const TeamProjectEdit = () => import('./components/team/project/edit-project');


export default [
    {path: '/dashboard', name: 'داشبورد', component: Dashboard},
    {path: '/profile', name: 'پروفایل', component: Profile},
    {path: '/teams', name: 'تیم ها', component: Team},
    {path: '/teams/create', name: 'ثبت تیم جدید', component: TeamCreate},
    {path: '/teams/:id/edit', name: 'ویرایش تیم', component: TeamEdit},
    {path: '/teams/:id/attachment', name: 'مدارک', component: TeamAttachment},
    {path: '/teams/:id/review', name: 'ارزیابی', component: TeamReview},
    {path: '/teams/:id/work-sample', name: 'نمونه کارها', component: TeamWorkSample},
    {path: '/teams/:id/member', name: 'اعضا', component: TeamMember},
    {path: '/teams/:id/reserved-project', name: 'پروژه های دریافتی', component: TeamReservedProjectIndex},
    {path: '/teams/:id/project', name: 'پروژه های ارسالی', component: TeamProjectIndex},
    {path: '/teams/:id/project/:pid/detail', name: 'جزییات پروژه', component: TeamProject},
    {path: '/teams/:id/reserved-project/:pid/detail', name: 'جزییات پروژه', component: TeamReservedProject},
    {path: '/teams/:id/project/create', name: 'ایجاد پروژه', component: TeamProjectCreate},
    {path: '/teams/:id/project/:pid/edit', name: 'ویرایش پروژه', component: TeamProjectEdit},


    {path: '*', component: {template: '<h4 class="text-center alert alert-danger">صفحه مورد نظر یافت نشد.</h4>'}}

]
